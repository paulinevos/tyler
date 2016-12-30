<?php

namespace AppBundle\Security;

use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Document\User;

class ApiUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        throw new NotImplementedException('Method not implemented.');
    }

    public function refreshUser(UserInterface $user)
    {
        throw new NotImplementedException('Method not implemented.');
    }

    public function supportsClass($class)
    {
        return User::class;
    }
}