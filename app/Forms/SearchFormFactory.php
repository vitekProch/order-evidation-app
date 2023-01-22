<?php

namespace App\Forms;
use Nette\Application\UI\Form;
use Nette;

class SearchFormFactory
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
        $form->addText('search_value', 'Jméno')
            ->setRequired(TRUE);
        $form->addSubmit('send', 'Send');
        $options =  [
            "0" => "Číslo zakázky",
            "1" => "Číslo materiálu",
        ];
        $form->addSelect('search_select', 'Search', $options);
        $form->onSuccess[] = [$this, 'searchFormSucceeded'];
        return $form;
    }

    public function searchFormSucceeded(Form $form, $values): void
    {
        $form->getPresenter()->redirect("Search:search", $values->search_value, $values->search_select);
    }

}