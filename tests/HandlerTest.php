<?php

namespace Insidestyles\SwooleBridge\Tests;

use Insidestyles\SwooleBridge\Adapter\SwooleAdapterInterface;
use Insidestyles\SwooleBridge\Handler;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
class HandlerTest extends BaseTestCase
{

    private Handler $instance;

    private MockObject $adapterMock;

    private MockObject $loggerMock;

    protected function setUp(): void
    {
        $this->adapterMock = $this->mock(SwooleAdapterInterface::class);
        $this->loggerMock = $this->mockPsrLogger();
        $this->instance = new Handler(
            $this->adapterMock,
            $this->loggerMock
        );
    }

    /**
     * @group handler
     */
    public function testHandle_WithError(): void
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleResponse = $this->mockSwooleResponse();
        $this->adapterMock->expects($this->once())->method('handle')
            ->willThrowException(new \Exception('handle error'));
        $this->loggerMock->expects($this->once())->method('error')->with('handle error');
        $this->instance->handle($swooleRequest, $swooleResponse);
    }

    /**
     * @group handler
     */
    public function testHandle(): void
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleResponse = $this->mockSwooleResponse();
        $this->adapterMock->expects($this->once())->method('handle')
            ->with($swooleRequest, $swooleResponse);
        $this->instance->handle($swooleRequest, $swooleResponse);
    }
}
