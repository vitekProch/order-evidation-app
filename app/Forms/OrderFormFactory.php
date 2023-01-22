<?php

namespace App\Forms;
use Nette;
use Nette\Application\UI\Form;
use App\Exceptions;

class OrderFormFactory
{
    /** @var FormFactory */
    private FormFactory $factory;

    use Nette\SmartObject;

    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(): Form
    {
        $form = $this->factory->create();
        $form->addText('order_id', 'Číslo Zakázky: ')
            ->addRule($form::LENGTH, 'Číslo zakázky může být krátné minimálně 6 číslic',[6,10])
            ->addRule($form::NUMERIC, 'Číslo zakázky se musí skládat pouze z číslic')
            ->setRequired('Vyplňte prosím %label');

        $form->addText('material_id', 'Číslo materiálu: ')
            ->addRule($form::LENGTH, 'Číslo materiálu může být krátné minimálně 6 číslic',[6,10])
            ->addRule($form::NUMERIC, 'Číslo materiálu se musí skládat pouze z číslic')
            ->setRequired('Vyplňte prosím %label');

        $diameters = $this->factory->tubeDiameterModel->getDiameters();
        $form->addSelect('diameters', 'Průměr: ', $diameters);

        $form->addText('made_quantity', 'Počet kusů: ')
            ->addRule($form::NUMERIC, 'Počet kusů se musí skládat pouze z číslic')
            ->addRule($form::MAX_LENGTH, 'Počet kusů může mít maximálně %d znaků', 4)
            ->setRequired('Vyplňte prosím %label');

        $form->addText('excess_quantity', 'Počet navíc: ')
            ->addRule($form::NUMERIC, 'Počet navíc musí obsahovat pouze číslice');

        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'orderFormSucceeded'];
        return $form;
    }
    public function orderFormSucceeded(Form $form,\stdClass $data): void
    {
        try {
            $name = $form->getPresenter()->user->getIdentity()->shift_id;
            $shift_id = $this->factory->shiftModel->getShiftByName($name);
            $this->factory->tubeProductionModel->insertNewData($data->order_id, $data->material_id, $form->getPresenter()->getUser()->id, $data->diameters, $data->made_quantity,$shift_id->shift_id, $data->excess_quantity);
            $form->getPresenter()->flashMessage('Zakázka byla uložena', 'success');
        }

        catch (Exceptions\DuplicateNameException $e){
            $form->getPresenter()->flashMessage("Číslo zakázky již existuje", 'error');
        }
    }
}