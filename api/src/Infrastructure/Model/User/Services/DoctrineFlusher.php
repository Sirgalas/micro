<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\User\Services;

use Api\Model\Flusher;
use Api\Model\AggregateRoot;
use Api\Model\EventDispatcher;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineFlusher
 * @package Api\Infrastructure\Model\User\Services
 * @property EntityManagerInterface $em
 * @property EventDispatcher $dispatcher
 */
class DoctrineFlusher implements Flusher
{
    private $em;
    private  $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcher $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher=$dispatcher;
    }

    public function flush(AggregateRoot ...$roots): void
    {
        $this->em->flush();

        $events = array_reduce($roots, function (array $events, AggregateRoot $root) {
            return array_merge($events, $root->releaseEvents());
        }, []);

        $this->dispatcher->dispatch(...$events);
    }
}
