<?php

$host = '127.0.0.1';
$port = 8080;

/** @var \Psr\Container\ContainerInterface $container */
$container = '...';
/** @var \Zend\Expressive\Application $app */
$psr15Kernel = $container->get(\Zend\Expressive\Application::class);

$http = new \swoole_http_server($host, $port);
$responseEmitter = new \Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitter();
$requestBuilderFactory = new \Insidestyles\SwooleBridge\Builder\RequestBuilderFactory();
$factory = new \Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory();
$adapter = new \Insidestyles\SwooleBridge\Adapter\SymfonyAdapter($responseEmitter, $psr15Kernel, $requestBuilderFactory);
$logger = new \Psr\Log\NullLogger();
$handler = new \Insidestyles\SwooleBridge\Handler($adapter, $logger);

$http->on(
    'request',
    function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use ($handler) {
        $handler->handle($request, $response);
    }
);

$http->start();