<?php

declare(strict_types=1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Exceptions;

final class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private FormFactory $factory;

	/** @var User */
	private User $user;


	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}

    public function create(): Form
    {
        $form = $this->factory->create();
        $form->addText('username', 'Zaměstnanecké číslo:')
            ->setRequired('Prosím vyplňte %label.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím vyplňte své heslo.');
        $shifts = [
            '1' => 'Ranní',
            '2' => 'Odpolední',
            '3' => 'Noční',
        ];

        $form->addSelect('shift', 'Směna: ', $shifts);

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }
    public function signInFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            $this->user->setExpiration('9 hour');
            $this->factory->employeeModel->insertShift($values->shift, $values->username);
            $form->getPresenter()->getUser()->login($values->username, $values->password);
            $form->getPresenter()->flashMessage('Přihlášení bylo úspěšné.','success');
            $form->getPresenter()->redirect('Homepage:');
        }
        catch (Exceptions\IncorrectNameException $e) {
            $form->getPresenter()->flashMessage('Nesprávné uživatelské jméno','error');
        }
        catch (Exceptions\IncorrectPassword $e) {
            $form->getPresenter()->flashMessage('Nesprávné uživatelské heslo','error');
        }
    }
}
