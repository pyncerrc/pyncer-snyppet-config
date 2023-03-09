<?php
namespace Pyncer\Snyppet\Config\Middleware;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;
use Pyncer\App\Identifier as ID;
use Pyncer\Http\Server\MiddlewareInterface;
use Pyncer\Http\Server\RequestHandlerInterface;
use Pyncer\Snyppet\Config\ConfigManager;

class ConfigMiddleware implements MiddlewareInterface
{
    public function __invoke(
        PsrServerRequestInterface $request,
        PsrResponseInterface $response,
        RequestHandlerInterface $handler
    ): PsrResponseInterface
    {
        $connection = $handler->get(ID::DATABASE);

        $config = new ConfigManager($connection);

        $config->preload();

        ID::register('config');

        $handler->set(ID::config(), $config);

        return $handler->next($request, $response);
    }
}
