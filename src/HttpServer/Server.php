<?php


namespace Xxm\HttpServer;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Hyperf\Utils\Context;
use Psr\Http\Message\RequestInterface as ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Hyperf\HttpMessage\Server\Response as Psr7Response;
use Hyperf\HttpMessage\Server\Request as Psr7Request;
use Xxm\HttpServer\Router\DispatcherFactory;
use function FastRoute\simpleDispatcher;


class Server
{
    /**
     * @var DispatcherFactory
     */
    protected $dispatcherFactory;

    protected $dispatcher;

    public function __construct(DispatcherFactory $dispatcherFactory)
    {
        $this->dispatcherFactory = $dispatcherFactory;
        $this->dispatcher = $this->dispatcherFactory->getDispatcher('http'); // 加载路由配置
    }

    public function onRequest(SwooleRequest $request, SwooleResponse $response): void
    {
        /** @var RequestInterface $psr7Request */
        /** @var ResponseInterface $psr7Response */
        [$psr7Request, $psr7Response] = $this->initRequestAndResponse($request, $response);
        $httpMethod = $psr7Request->getMethod();
        $uri = $psr7Request->getUri()->getPath();

        // FastRoute
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response->status(404);
                $response->end('Not Found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $response->status(405);
                $response->header('Method-Allows', implode(',', $allowedMethods));
                $response->end();
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$controller, $action] = $handler;
                $instance = new $controller();
                $result = $instance->$action(...$vars);
                $response->end($result);
                break;
        }
    }

    protected function initRequestAndResponse(SwooleRequest $request, SwooleResponse $response): array
    {
        Context::set(ResponseInterface::class, $psr7Response = new Psr7Response());
        Context::set(ServerRequestInterface::class, $psr7Request= Psr7Request::loadFromSwooleRequest($request));
        return [$psr7Request, $psr7Response];
    }
}