<?php

namespace App\Tests\Unit\Model\User\Entity\User\Signup;

use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());

        self::assertNull($user->getConfirmToken());
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();
        $this->expectExceptionMessage('User is already confirmed.');
        $user->confirmSignUp();
    }
}
