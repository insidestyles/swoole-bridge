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
        $this->appMock = $this->mockSymfonyKernel();
        $this->requestBuilderFactoryMock = $this->mockRequestBuilderFactory();
        $this->responseEmitterMock = $this->mockSwooleResponseEmitterInterface();
        $this->psr7FactoryMock = $this->mockDiactorosFactory();
        $this->instance = new SymfonyAdapter(
            $this->appMock,
            $this->responseEmitterMock,
            $this->requestBuilderFactoryMock,
            $this->psr7FactoryMock
        );
    }

    /**
     * @group adapter
     */
    public function testHandle()
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleResponse = $this->mockSwooleResponse();
        $sfRequest = $this->mockSfRequest();
        $sfResponse = $this->mockSfResponse();
        $this->requestBuilderFactoryMock->expects($this->once())->method('createSymfonyRequest')
            ->with($swooleRequest)
            ->willReturn($sfRequest);
        $this->appMock->expects($this->once())->method('handle')
            ->with($sfRequest)
            ->willReturn($sfResponse);
        $psrResonse = $this->mockPsrResponse();
        $this->psr7FactoryMock->expects($this->once())->method('createResponse')
            ->with($sfResponse)
            ->willReturn($psrResonse);
        $this->responseEmitterMock->expects($this->once())->method('toSwoole')
            ->with($psrResonse, $swooleResponse);
        $this->instance->handle($swooleRequest, $swooleResponse);
    }
}
