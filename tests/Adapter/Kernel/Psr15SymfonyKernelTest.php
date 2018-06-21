<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 21.06.18
 * Time: 9:08
 */

namespace Insidestyles\SwooleBridge\Tests\Adapter\Kernel;

use Insidestyles\SwooleBridge\Adapter\Kernel\Psr15SymfonyKernel;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Psr15SymfonyKernelTest
 * @package Insidestyles\SwooleBridge\Tests\Adapter\Kernel
 */
class Psr15SymfonyKernelTest extends BaseTestCase
{
    /**
     * @var Psr15SymfonyKernel
     */
    private $instance;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|HttpKernelInterface
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
        $this->httpKernelMock = $this->mockHttpKernelInterface();
        $this->httpFoundationFactoryMock = $this->mockHttpFoundationFactoryInterface();
        $this->httpMessageFactoryMock = $this->mockHttpMessageFactoryInterface();
        $this->instance = new Psr15SymfonyKernel(
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
