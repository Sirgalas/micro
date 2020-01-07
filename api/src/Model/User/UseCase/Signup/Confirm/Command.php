<?php
declare(strict_types=1);

namespace Api\Model\User\UseCase\Signup\Confirm;


class Command
{
    public $email;
    public $token;
}
