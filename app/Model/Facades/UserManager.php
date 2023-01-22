<?php

declare(strict_types=1);

namespace App\Model\Facades;

use Nette;
use Nette\Security\Passwords;
use App\Exceptions;

/**
 * Users management.
 */
final class UserManager implements Nette\Security\IAuthenticator
{
    use Nette\SmartObject;

    private const
        TABLE_NAME = 'employee',
        COLUMN_ID = 'id',
        COLUMN_NAME = 'name',
        COLUMN_PASSWORD_HASH = 'password',
        COLUMN_EMPLOYEE_ID = 'employee_id',
        COLUMN_ROLE = 'role';


    /** @var Nette\Database\Context */
    private Nette\Database\Context $database;

    /** @var Passwords */
    private Passwords $passwords;


    public function __construct(Nette\Database\Context $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }


    /**
     * Performs an authentication.
     */
    public function authenticate(array $credentials): Nette\Security\IIdentity
    {
        [$employee_id, $password] = $credentials;

        $row = $this->database->table(self::TABLE_NAME)
            ->where(self::COLUMN_EMPLOYEE_ID, $employee_id)
            ->fetch();


        if (!$row) {
            throw new Exceptions\IncorrectNameException();

        } elseif (!$this->passwords->verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            throw new Exceptions\IncorrectPassword();

        } elseif ($this->passwords->needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            $row->update([
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
            ]);
        }

        $arr = $row->toArray();
        unset($arr[self::COLUMN_PASSWORD_HASH]);
        return new Nette\Security\Identity($row[self::COLUMN_EMPLOYEE_ID],$row[self::COLUMN_ROLE], $arr);
    }


    public function add(string $username, string $password, string $employee_id): void
    {

        try {
            $this->database->table(self::TABLE_NAME)->insert([
                self::COLUMN_NAME => $username,
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
                self::COLUMN_EMPLOYEE_ID => $employee_id,
                self::COLUMN_ROLE =>'logged_in',

            ]);
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            throw new Exceptions\DuplicateNameException();
        }
    }
}