<?php

namespace Insidestyles\SwooleBridge\Tests\Adapter;

use Insidestyles\SwooleBridge\Adapter\SymfonyAdapter;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;

/**
 * Class SymfonyAdapterTest
 * @package Insidestyles\SwooleBridge\Tests\Adapter
 */
class SymfonyAdapterTest extends BaseTestCase
{
    /**
     * @var SymfonyAdapter
     */
    private $instance;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $appMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $requestBuilderFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $responseEmitterMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $psr7FactoryMock;

    protected function setUp()
    {
        $this->appMock = $this->mockPsr15SymfonyKernel();
        $this->requestBuilderFactoryMock = $this->mockRequestBuilderFactory();
        $this->responseEmitterMock = $this->mockSwooleResponseEmitterInterface();
        $this->psr7FactoryMock = $this->mockDiactorosFactory();
        $this->instance = new SymfonyAdapter(
            $this->responseEmitterMock,
            $this->appMock,
            $this->requestBuilderFactoryMock
        );
    }

    /**
     * @group adapter
     */
    public function testHandle()
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleResponse = $this->mockSwooleResponse();
        $serverRequest = $this->mockPsrServerRequest();
        $psrResonse = $this->mockPsrResponse();
        $this->requestBuilderFactoryMock->expects($this->once())->method('createServerRequest')
            ->with($swooleRequest)
            ->willReturn($serverRequest);
        $this->appMock->expects($this->once())->method('handle')
            ->with($serverRequest)
            ->willReturn($psrResonse);
        $psrResonse = $this->mockPsrResponse();
        $this->responseEmitterMock->expects($this->once())->method('toSwoole')
            ->with($psrResonse, $swooleResponse);
        $this->instance->handle($swooleRequest, $swooleResponse);
    }
}
