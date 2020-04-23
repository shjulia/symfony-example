<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Email\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email = '';

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}