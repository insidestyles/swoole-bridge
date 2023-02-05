<?php

namespace Insidestyles\SwooleBridge\Tests\Adapter\Kernel;

use Illuminate\Contracts\Http\Kernel;
use Insidestyles\SwooleBridge\Adapter\Kernel\Psr15IllumimateKernel;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
class Psr15IllumimateKernelTest extends BaseTestCase
{
    private Psr15IllumimateKernel $instance;

    private MockObject|Kernel $httpKernelMock;

    private MockObject $httpFoundationFactoryMock;

    private MockObject $httpMessageFactoryMock;

    protected function setUp(): void
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
    public function testHandle(): void
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