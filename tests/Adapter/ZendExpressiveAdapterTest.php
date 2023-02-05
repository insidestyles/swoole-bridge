<?php

namespace Insidestyles\SwooleBridge\Tests\Adapter;

use Insidestyles\SwooleBridge\Adapter\ZendExpressiveAdapter;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
class ZendExpressiveAdapterTest extends BaseTestCase
{

    private ZendExpressiveAdapter $instance;

    private MockObject $appMock;

    private MockObject $requestBuilderFactoryMock;

    private MockObject $responseEmitterMock;

    protected function setUp(): void
    {
        $this->appMock = $this->mockZendApp();
        $this->requestBuilderFactoryMock = $this->mockRequestBuilderFactory();
        $this->responseEmitterMock = $this->mockSwooleResponseEmitterInterface();
        $this->instance = new ZendExpressiveAdapter(
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
        $this->responseEmitterMock->expects($this->once())->method('toSwoole')
            ->with($psrResonse, $swooleResponse);
        $this->instance->handle($swooleRequest, $swooleResponse);
    }
}
