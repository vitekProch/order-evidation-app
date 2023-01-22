<?php

namespace App\Forms;
use Nette;
use Nette\Application\UI\Form;

class ExcessEditFormFactory
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
        $form->addText('material_id', 'Číslo materiálu')
            ->addRule($form::LENGTH, 'Číslo materuálu může být krátné minimálně 6 číslic',[6,7])
            ->addRule($form::NUMERIC, 'Číslo materuálu se musí skládat pouze z číslic')
            ->setRequired('Vyplňte prosím %label');

        $diameter = $this->factory->tubeDiameterModel->getDiameters();
        $form->addHidden('id');
        $form->addSelect('diameter_id', 'Průměr: ', $diameter);

        $form->addText('quantity', 'Počet kusů')
            ->addRule($form::NUMERIC, 'Počet kusů se musí skládat pouze z číslic')
            ->addRule($form::MAX_LENGTH, 'Počet kusů může mít maximálně %d znaků', 4)
            ->setRequired('Vyplňte prosím %label');

        $form->addSubmit('ok', 'Upravit');
        $form->onSuccess[] = array($this, 'formSubmitted');

        return $form;
    }
    public function formSubmitted(Form $form, $data) {

        $this->factory->tubeExcessModel->newExcess($data->id, $data->material_id, $data->quantity, $data->diameter_id);

        $form->getPresenter()->flashMessage('Úprava záznamu byla úspěsná', 'success');

    }
}