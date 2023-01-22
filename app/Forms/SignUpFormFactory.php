<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model;
use Nette;
use Nette\Application\UI\Form;
use App\Exceptions;

final class SignUpFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private FormFactory $factory;

	/** @var Model\Facades\UserManager */
	private Model\Facades\UserManager $userManager;


	public function __construct(FormFactory $factory, Model\Facades\UserManager $userManager)
	{
		$this->factory = $factory;
		$this->userManager = $userManager;
	}


	public function create(): Form
	{
        $form = $this->factory->create();
        $form->addText('username', 'Jméno zaměstnance: ')
            ->setRequired('Vyplňte prosím %label');

        $form->addText('employee_id', 'Číslo zaměstnance: ')
            ->addRule($form::NUMERIC, 'Číslo zaměstnance se musí skládat pouze z číslic')
            ->addRule($form::MIN_LENGTH, 'Číslo musí mít alespoň %d znaků', 4)
            ->setRequired('Vyplňte prosím %label');

        $form->addPassword('password', 'Heslo: ');
        $form->addPassword('passwordVerify', 'Heslo pro kontrolu:')
            ->setRequired('Zadejte prosím heslo ještě jednou pro kontrolu')
            ->addRule($form::EQUAL, 'Hesla se neshodují', $form['password'])
            ->setOmitted();

        $form->addSubmit('send', 'Registrovat');
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
	}

    public function formSucceeded(Form $form, $data): void
    {
        try {
            $this->userManager->add($data->username,$data->password, $data->employee_id);
            $form->getPresenter()->flashMessage('Zaměstnanec byl úspěšně registrován.', 'success');
            $form->getPresenter()->redirect('Homepage:');
        }
        catch (Exceptions\DuplicateNameException $e){
            $form->getPresenter()->flashMessage("Číslo zaměstnance již existuje", 'error');
        }
    }

}
