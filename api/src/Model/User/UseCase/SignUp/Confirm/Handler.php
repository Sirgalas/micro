<?php
declare(strict_types=1);

namespace Api\Model\User\UseCase\SignUp\Confirm;

use Api\Model\EventDispatcher;
use Api\Model\Flusher;
use Api\Model\User\Entity\User\Email;
use Api\Model\User\Entity\User\UserRepository;

/**
 * Class Handler
 * @package Api\Model\User\UseCase\SignUp\Confirm
 * @property UserRepository $users
 * @property Flusher $flusher
 */
class Handler
{
    private $users;
    private $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }
    public function handle(Command $command): void
    {
        $user = $this->users->getByEmail(new Email($command->email));

        $user->confirmSignUp($command->token, new \DateTimeImmutable());

        $this->flusher->flush();

    }
}
