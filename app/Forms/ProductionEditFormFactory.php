<?php

namespace App\Forms;
use Nette;
use Nette\Application\UI\Form;

class ProductionEditFormFactory
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

        $form->addText('material_id', 'Číslo materialu')
            ->addRule($form::LENGTH, '%label může být krátné minimálně 6 číslic',[6,10])
            ->addRule($form::NUMERIC, '%label se musí skládat pouze z číslic')
            ->setRequired('Vyplňte prosím %label');

        $form->addHidden("back_to");

        $form->addText('order_id', 'Číslo zakázky')
            ->addRule($form::LENGTH, '%label může být krátné minimálně 6 číslic',[6,10])
            ->addRule($form::NUMERIC, '%label se musí skládat pouze z číslic')
            ->setRequired('Vyplňte prosím %label');
        $form->addHidden('id');
        $diameter = $this->factory->tubeDiameterModel->getDiameters();
        $form->addSelect('diameter_id', 'Průměr: ', $diameter);

        $form->addText('made_quantity', 'Počet kusů')
            ->addRule($form::NUMERIC, '%label se musí skládat pouze z číslic')
            ->addRule($form::MAX_LENGTH, '%label může mít maximálně %d znaků', 4)
            ->setRequired('Vyplňte prosím %label');

        $shifts = [
            '1' => 'Ranní',
            '2' => 'Odpolední',
            '3' => 'Noční',
        ];

        $form->addSelect('shift_id', 'Směna: ', $shifts);
        $form->setDefaults(["shift" => 3, "diameter" => 2]);

        $form->addText('excess_quantity', 'Počet navíc')
            ->addRule($form::NUMERIC, '%label se musí skládat pouze z číslic');

        $form->addSubmit('save', 'Uložit');

        $form->onSuccess[] = [$this, 'editFormSucceeded'];
        return $form;
    }

    public function editFormSucceeded(Form $form, array $values): void
    {
        $this->factory->tubeProductionModel->updateNewData(
            $values['id'],
            $values['material_id'],
            $values['diameter_id'],
            $values['made_quantity'],
            $values['shift_id'],
            $values['order_id'],
            $values['excess_quantity']);

        $form->getPresenter()->flashMessage('Zakázka byla upravena.', 'success');
        if ($values['back_to'] != ""){
            $form->getPresenter()->redirect($values['back_to']);
        }
        $form->getPresenter()->redirect("TubeProduction:production");
    }

}