<?php

declare(strict_types=1);

use Api\Infrastructure;
use Api\Infrastructure\Model\User as UserInfrastructure;
use Api\Model\User as UserModel;
use Api\ReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Api\Infrastructure\Model\Video as VideoInfrastructure;
use Api\Model\Video as VideoModel;

return [
    Api\Model\Flusher::class => function (ContainerInterface $container) {
        return new UserInfrastructure\Services\DoctrineFlusher(
            $container->get(EntityManagerInterface::class),
            $container->get(Api\Model\EventDispatcher::class)
        );
    },

    UserModel\Service\PasswordHasher::class => function () {
        return new UserInfrastructure\Services\BCryptPasswordHasher();
    },

    UserModel\Entity\User\UserRepository::class => function (ContainerInterface $container) {
        return new UserInfrastructure\Entities\DoctrineUserRepository(
            $container->get(EntityManagerInterface::class)
        );
    },

    UserModel\Service\ConfirmTokenizer::class => function (ContainerInterface $container) {
        $interval = $container->get('config')['auth']['SignUp_confirm_interval'];
        return new UserInfrastructure\Services\RandConfirmTokenizer(new \DateInterval($interval));
    },

    UserModel\Entity\User\UserRepository::class => function (ContainerInterface $container) {
        return new UserInfrastructure\Entities\DoctrineUserRepository(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class)
        );
    },

    UserModel\UseCase\SignUp\Request\Handler::class => function (ContainerInterface $container) {
        return new UserModel\UseCase\SignUp\Request\Handler(
            $container->get(UserModel\Entity\User\UserRepository::class),
            $container->get(UserModel\Service\PasswordHasher::class),
            $container->get(UserModel\Service\ConfirmTokenizer::class),
            $container->get(Api\Model\Flusher::class)
        );
    },

    UserModel\UseCase\SignUp\Confirm\Handler::class => function (ContainerInterface $container) {
        return new UserModel\UseCase\SignUp\Confirm\Handler(
            $container->get(UserModel\Entity\User\UserRepository::class),
            $container->get(Api\Model\Flusher::class)
        );
    },

    ReadModel\User\UserReadRepository::class => function (ContainerInterface $container) {
        return new Infrastructure\ReadModel\User\DoctrineUserReadRepository(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class)
        );
    },
    VideoModel\UseCase\Author\Create\Handler::class => function (ContainerInterface $container) {
        return new VideoModel\UseCase\Author\Create\Handler(
            $container->get(VideoModel\Entity\Author\AuthorRepository::class),
            $container->get(Api\Model\Flusher::class)
        );
    },

    ReadModel\Video\AuthorReadRepository::class => function (ContainerInterface $container) {
        return new Infrastructure\ReadModel\Video\DoctrineAuthorReadRepository(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class)
        );
    },
    VideoModel\Entity\Author\AuthorRepository::class => function (ContainerInterface $container) {
        return new VideoInfrastructure\Entity\DoctrineAuthorRepository(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class)
        );
    },

    'config' => [
        'auth' => [
            'SignUp_confirm_interval' => 'PT5M',
        ],
    ],
];
