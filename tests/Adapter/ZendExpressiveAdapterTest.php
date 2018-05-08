<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 07.05.18
 * Time: 15:33
 */

namespace Insidestyles\SwooleBridge\Tests\Adapter;

use Insidestyles\SwooleBridge\Adapter\ZendExpressiveAdapter;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;


class ZendExpressiveAdapterTest extends BaseTestCase
{
    /**
     * @var ZendExpressiveAdapter
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

    protected function setUp()
    {
        $this->appMock = $this->mockZendApp();
        $this->requestBuilderFactoryMock = $this->mockRequestBuilderFactory();
        $this->responseEmitterMock = $this->mockSwooleResponseEmitterInterface();
        $this->instance = new ZendExpressiveAdapter(
            $this->appMock,
            $this->responseEmitterMock,
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
        $this->requestBuilderFactoryMock->expects($this->once())->method('createZendExpressiveRequest')
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
