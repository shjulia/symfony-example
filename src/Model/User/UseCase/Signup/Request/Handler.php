<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Signup\Request;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\ConfirmTokenizer;
use App\Model\User\Service\ConfirmTokenSender;
use App\Model\User\Service\PasswordsHasher;

class Handler
{
    /**
     * @var UserRepository
     */
    private UserRepository $users;
    /**
     * @var PasswordsHasher
     */
    private PasswordsHasher $hasher;
    /**
     * @var Flusher
     */
    private Flusher $flusher;
    /**
     * @var ConfirmTokenizer
     */
    private ConfirmTokenizer $tokenizer;
    /**
     * @var ConfirmTokenSender
     */
    private ConfirmTokenSender $sender;

    public function __construct(
        UserRepository $users,
        PasswordsHasher $hasher,
        ConfirmTokenizer $tokenizer,
        ConfirmTokenSender $sender,
        Flusher $flusher
    )
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
        $this->tokenizer = $tokenizer;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);
        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('User already exists.');
        }

        $user = new User(
            Id::next(),
            new \DateTimeImmutable(),
            $email,
            $this->hasher->hash($command->password),
            $token = $this->tokenizer->generate()
        );

        $this->users->add($user);
        $this->sender->send($email, $token);
        $this->flusher->flush();
    }
}