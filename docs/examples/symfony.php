<?php
$kernel = new Kernel($env, $debug);//App\Kernel or AppKernel;

$host = '127.0.0.1';
$port = 8080;

$http = new \swoole_http_server($host, $port);
$responseEmitter = new \Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitter();
$requestBuilderFactory = new \Insidestyles\SwooleBridge\Builder\RequestBuilderFactory();
$factory = new \Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory();
$adapter = new \Insidestyles\SwooleBridge\Adapter\SymfonyAdapter($responseEmitter, $requestBuilderFactory);
$psr15Kernel = new \Insidestyles\SwooleBridge\Adapter\Kernel\Psr15SymfonyKernel($kernel);
$adapter->setRequestHandler($psr15Kernel);
$handler = new \Insidestyles\SwooleBridge\Handler($adapter, $logger);

$http->on(
    'request',
    function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use ($handler) {
        $handler->handle($request, $response);
    }
);

$http->start();