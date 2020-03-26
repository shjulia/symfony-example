<?php

namespace App\Tests\Unit\Model\User\Entity\User\Signup;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $id = Id::next(),
            $date = new \DateTimeImmutable(),
        );

        $user->signUpByEmail(
            $email = new Email('test@app.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($date, $user->getDate());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($hash, $user->getPasswordHash());
        $this->assertEquals($token, $user->getConfirmToken());
    }

    public function testAlready(): void
    {
        $user = new User (
            $id = Id::next(),
            $date = new \DateTimeImmutable()
        );

        $user->signUpByEmail(
            $email = new Email('test@app.test'),
            $hash = 'hash',
            $token = 'token'
        );

        $this->expectExceptionMessage('User is already signed up.');
        $user->signUpByEmail($email, $hash, $token);
    }
}
