<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\User;

class UserNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('user.user_not_found');
    }
}
