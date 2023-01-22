<?php


namespace App\Model;
use Nette\Security\Permission;

class AuthorizationFactory
{
    const ROLE_GUEST = 'guest';
    const ROLE_REGISTERED = 'logged_in';
    const ROLE_ADMIN = 'admin';

    public function create(): Permission
    {
        $acl = new Permission;

        /**
         * Role
         */
        $acl->addRole(self::ROLE_GUEST);
        $acl->addRole(self::ROLE_REGISTERED, self::ROLE_GUEST);
        $acl->addRole(self::ROLE_ADMIN, self::ROLE_REGISTERED);

        /**
         * Resource
         */
        $acl->addResource('register');
        $acl->addResource('signIn');


        /**
         * Permission
         */
        $acl->allow(self::ROLE_GUEST,'signIn','view');
        $acl->deny(self::ROLE_REGISTERED, 'signIn', 'view');
        $acl->allow(self::ROLE_ADMIN, $acl::ALL, $acl::ALL);

        return $acl;
    }

}