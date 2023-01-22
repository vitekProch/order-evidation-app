<?php

namespace App\Forms;
use Nette;
use Nette\Application\UI\Form;


class ExcessFormFactory
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

        $form->addText('material_id', 'Číslo zakázky:')
            ->addRule($form::LENGTH, 'Číslo zakázky může být krátné minimálně 6 číslic',[6,7])
            ->addRule($form::NUMERIC, 'Číslo zakázky se musí skládat pouze z číslic')
            ->setRequired('Vyplňte prosím %label');

        $form->addText('quantity', 'Počet navíc:')
            ->setRequired('Vyplňte prosím %label')
            ->addRule($form::NUMERIC, 'Počet kusů se musí skládat pouze z číslic')
            ->addRule($form::MAX_LENGTH, 'Počet kusů může mít maximálně %d znaků', 4);
        $diameters = $this->factory->tubeDiameterModel->getDiameters();
        $form->addSelect('diameters', 'Průměr: ', $diameters);

        $form->addSubmit('save', 'Uložit');

        $form->onSuccess[] = [$this, 'excessFormSucceeded'];

        return $form;
    }

    public function excessFormSucceeded(Form $form,\stdClass $data) {
        $excess = $this->factory->tubeExcessModel->checkExcess($data->material_id);
        if(is_null($excess)){
            $this->factory->tubeExcessModel->insertExcess(
                $data->material_id,
                $data->quantity,
                $data->diameters,
            );
            $form->getPresenter()->flashMessage("Záznam byl úspěsně uložen", "success");
        }
        else
        {
            $this->factory->tubeExcessModel->updateExcess($data->material_id, $data->quantity, $data->diameters);
            $form->getPresenter()->flashMessage("Záznam byl úspěsně upraven", "success");
        }
    }
}