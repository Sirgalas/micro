<?php
namespace Api\Http\Action;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
class HomeAction
{
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        return new JsonResponse([
            'name'=>'App API',
            'version'=>'1.0'
        ]);
    }
}
