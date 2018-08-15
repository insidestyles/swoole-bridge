<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 15.08.18
 * Time: 12:23
 */

namespace Insidestyles\SwooleBridge\Tests\Adapter\Kernel;

use Illuminate\Contracts\Http\Kernel;
use Insidestyles\SwooleBridge\Adapter\Kernel\Psr15IllumimateKernel;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Psr15IllumimateKernelTest
 * @package Insidestyles\SwooleBridge\Tests\Adapter\Kernel
 */
class Psr15IllumimateKernelTest extends BaseTestCase
{
    /**
     * @var Psr15IllumimateKernel
     */
    private $instance;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Kernel
     */
    private $httpKernelMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpFoundationFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpMessageFactoryMock;

    protected function setUp()
    {
        $this->httpKernelMock = $this->mockIlluminateKernelInterface();
        $this->httpFoundationFactoryMock = $this->mockHttpFoundationFactoryInterface();
        $this->httpMessageFactoryMock = $this->mockHttpMessageFactoryInterface();
        $this->instance = new Psr15IllumimateKernel(
            $this->httpKernelMock,
            $this->httpFoundationFactoryMock,
            $this->httpMessageFactoryMock
        );
    }

    /**
     * @throws \Exception
     */
    public function testHandle()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->mockPsrServerRequest();
        $sfRequest = $this->mockSfRequest();
        $this->httpFoundationFactoryMock->expects($this->once())->method('createRequest')
            ->with($request)
            ->willReturn($sfRequest);
        $sfResponse = $this->mockSfResponse();
        $this->httpKernelMock->expects($this->once())->method('handle')
            ->with($sfRequest)
            ->willReturn($sfResponse);
        $psrResponse = $this->mockPsrResponse();
        $this->httpMessageFactoryMock->expects($this->once())->method('createResponse')
            ->with($sfResponse)
            ->willReturn($psrResponse);
        $res = $this->instance->handle($request);
        $this->assertSame($psrResponse, $res);
    }
}