<?php

namespace Lovetrytry\Jichukuangjia\Middleware;

use \ArrayObject;
use Hyperf\Contract\ConfigInterface;
use Lovetrytry\Jichukuangjia\Exception\RuntimeException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Response implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Constructs a new instance.
     *
     * @author     lovetrytry@yeah.net
     *
     * @param      \Psr\Container\ContainerInterface  $container  The container
     * @param      \Hyperf\Contract\ConfigInterface   $config     The configuration
     */
    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * { function_description }
     *
     * @author     lovetrytry@yeah.net
     *
     * @param      \Psr\Http\Message\ServerRequestInterface  $request  The request
     * @param      \Psr\Http\Server\RequestHandlerInterface  $handler  The handler
     *
     * @return     ResponseInterface                         The response interface.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response;
    }
}
