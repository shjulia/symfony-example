<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Signup\Request;

class Command
{
    public string $email;

    public string $password;
}