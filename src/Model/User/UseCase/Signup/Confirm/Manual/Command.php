<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Signup\Confirm\Manual;

class Command
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}