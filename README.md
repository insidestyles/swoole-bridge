# swoole-bridge
Swoole Bridge For Php Frameworks. Currently supports:
* Symfony
* Zend Expressive
* Laravel

## Requirements

* PHP >= 7.2
* [ext-swoole](https://pecl.php.net/package/swoole) >= 2.1


## Installation

This package is installable and autoloadable via Composer 

```sh
composer require insidestyles/swoole-bridge
```
 
## Usage
    example:
```php
<?php
   $kernel = new Kernel($env, $debug);//App\Kernel or AppKernel;
   $psr15Kernel = new \Insidestyles\SwooleBridge\Adapter\Kernel\Psr15SymfonyKernel($kernel);
   
   //Laravel: $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
   //$psr15Kernel = new \Insidestyles\SwooleBridge\Adapter\Kernel\Psr15IlluminateKernel($kernel);
   
   //Zend Expressive: $psr15Kernel = $container->get(\Zend\Expressive\Application::class);
   
   $host = '127.0.0.1';
   $port = 8080;
   
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
```


## TODO
- [x] Laravel support?
- [ ] Yii support?