<?php

declare(strict_types=1);

namespace Api\Test\Unit\Model\User\Entity\User;

use Api\Model\User\Entity\User\ConfirmToken;
use Api\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;
use Api\Test\Builder\User\UserBuilder;

class ConfirmTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testSuccess(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ConfirmToken('token', $now->modify('+1 day'));
        $user = $this->SignUp($now,$token);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertNotNull($user->getConfirmToken());

        $user->confirmSignUp($token->getToken(), $now);

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
        self::assertNull($user->getConfirmToken());
    }

    /**
     * @throws \Exception
     */
    public function testInvalidToken(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ConfirmToken('token', $now->modify('+1 day'));
        $user = $this->SignUp($now, $token);

        $this->expectExceptionMessage('Confirm token is invalid.');
        $user->confirmSignUp('invalid', $now);
    }

    /**
     * @throws \Exception
     */
    public function testExpiredToken(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ConfirmToken('token', $now);
        $user = $this->SignUp($now, $token);

        $this->expectExceptionMessage('Confirm token is expired.');
        $user->confirmSignUp($token->getToken(), $now->modify('+1 day'));
    }

    /**
     * @throws \Exception
     */
    public function testAlreadyActive(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ConfirmToken('token', $now->modify('+1 day'));

        $user = $this->SignUp($now, $token);

        $user->confirmSignUp($token->getToken(), $now);
        $this->expectExceptionMessage('User is already active.');

        $user->confirmSignUp($token->getToken(), $now);
    }

    /**
     * @param ConfirmToken $token
     * @return User
     * @throws \Exception
     */
    private function SignUp(\DateTimeImmutable $date, ConfirmToken $token): User
    {
        return (new UserBuilder())
            ->withDate($date)
            ->withConfirmToken($token)
            ->build();
    }
}
