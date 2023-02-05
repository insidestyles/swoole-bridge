<?php

namespace Insidestyles\SwooleBridge\Tests\Builder;

use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Request as SfRequest;

class RequestBuilderFactoryTest extends BaseTestCase
{
    private RequestBuilderFactory $instance;

    protected function setUp(): void
    {
        $this->instance = new RequestBuilderFactory();
    }

    /**
     * @group builder
     */
    public function testCreateServerRequest(): void
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleRequest->header = [];
        $swooleRequest->server = [];
        $swooleRequest->expects($this->once())->method('rawContent')
            ->willReturn('');
        $res = $this->instance->createServerRequest($swooleRequest);
        $this->assertInstanceOf(ServerRequestInterface::class, $res);
    }
}
