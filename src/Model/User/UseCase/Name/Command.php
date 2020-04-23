<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Name;

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
     */
    public string $firstName;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string  $lastName;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}