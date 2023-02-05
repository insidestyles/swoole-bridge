<?php

namespace Insidestyles\SwooleBridge\Tests\Adapter;

use Insidestyles\SwooleBridge\Adapter\SymfonyAdapter;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
class SymfonyAdapterTest extends BaseTestCase
{
    private SymfonyAdapter $instance;

    private MockObject $appMock;

    private MockObject $requestBuilderFactoryMock;

    private MockObject $responseEmitterMock;

    private MockObject $psr7FactoryMock;

    protected function setUp(): void
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
    public function testHandle(): void
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
