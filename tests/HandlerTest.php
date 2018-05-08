<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 08.05.18
 * Time: 9:32
 */

namespace Insidestyles\SwooleBridge\Tests;

use Insidestyles\SwooleBridge\Adapter\SwooleAdapterInterface;
use Insidestyles\SwooleBridge\Handler;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;

/**
 * Class HandlerTest
 * @package Insidestyles\SwooleBridge\Tests
 */
class HandlerTest extends BaseTestCase
{
    /**
     * @var Handler
     */
    private $instance;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $adapterMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $loggerMock;

    protected function setUp()
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
    public function testHandle_WithError()
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
    public function testHandle()
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleResponse = $this->mockSwooleResponse();
        $this->adapterMock->expects($this->once())->method('handle')
            ->with($swooleRequest, $swooleResponse);
        $this->instance->handle($swooleRequest, $swooleResponse);
    }
}
