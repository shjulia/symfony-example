<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\User;
use App\Model\User\Service\PasswordsHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private PasswordsHasher $hasher;

    public function __construct(PasswordsHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $hash = $this->hasher->hash('password');

        $user = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Name('James', 'Bond'),
            new Email('admin@app.test'),
            $hash,
            'token'
        );

        $user->confirmSignUp();
        $user->changeRole(Role::admin());

        $manager->persist($user);
        $manager->flush();
    }
}