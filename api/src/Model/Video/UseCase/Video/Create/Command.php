<?php

declare(strict_types=1);

namespace Api\Model\Video\UseCase\Video\Create;

use Psr\Http\Message\UploadedFileInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $author;
    /**
     * @var UploadedFileInterface
     * @Assert\NotBlank()
     */
    public $file;
}
