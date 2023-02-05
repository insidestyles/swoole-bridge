<?php

namespace Insidestyles\SwooleBridge\Tests\Traits;

use Insidestyles\SwooleBridge\Adapter\Kernel\Psr15SymfonyKernel;
use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Zend\Expressive\Application as ZendApp;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Request as SfRequest;
use Symfony\Component\HttpFoundation\Response as SfResponse;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
trait ServiceMocksTrait
{

    protected function mock($className): MockObject
    {
        return self::getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function mockPsrLogger(): MockObject
    {
        return $this->mock(LoggerInterface::class);
    }

    protected function mockSymfonyKernel(): MockObject
    {
        return $this->mock(Kernel::class);
    }

    protected function mockPsr15SymfonyKernel(): MockObject
    {
        return $this->mock(Psr15SymfonyKernel::class);
    }

    protected function mockZendApp(): MockObject
    {
        return $this->mock(RequestHandlerInterface::class);
    }

    protected function mockSwooleResponseEmitterInterface(): MockObject
    {
        return $this->mock(SwooleResponseEmitterInterface::class);
    }

    protected function mockRequestBuilderFactory(): MockObject
    {
        return $this->mock(RequestBuilderFactory::class);
    }

    protected function mockDiactorosFactory(): MockObject
    {
        return $this->mock(DiactorosFactory::class);
    }

    protected function mockPsrResponse(): MockObject
    {
        return $this->mock(PsrResponse::class);
    }

    protected function mockPsrServerRequest(): MockObject
    {
        return $this->mock(ServerRequestInterface::class);
    }

    protected function mockSwooleRequest(): MockObject
    {
        return $this->mock(SwooleRequest::class);
    }

    protected function mockSwooleResponse(): MockObject
    {
        return $this->mock(SwooleResponse::class);
    }

    protected function mockSfRequest(): MockObject
    {
        return $this->mock(SfRequest::class);
    }
    
    protected function mockSfResponse(): MockObject
    {
        return $this->mock(SfResponse::class);
    }
    
    protected function mockHttpKernelInterface(): MockObject
    {
        return $this->mock(HttpKernelInterface::class);
    }

    protected function mockIlluminateKernelInterface(): MockObject
    {
        return $this->mock(\Illuminate\Contracts\Http\Kernel::class);
    }
    
    protected function mockHttpFoundationFactoryInterface(): MockObject
    {
        return $this->mock(HttpFoundationFactoryInterface::class);
    }
    
    protected function mockHttpMessageFactoryInterface(): MockObject
    {
        return $this->mock(HttpMessageFactoryInterface::class);
    }
}