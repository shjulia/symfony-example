<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Signup\Confirm\Manual;

use App\Model\Flusher;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    /**
     * @var UserRepository
     */
    private UserRepository $users;

    /**
     * @var Flusher
     */
    private Flusher $flusher;

    public function __construct(
        UserRepository $users,
        Flusher $flusher
    ) {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $user->confirmSignUp();
        $this->flusher->flush();
    }
}