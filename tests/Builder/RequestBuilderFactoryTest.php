<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 07.05.18
 * Time: 15:40
 */

namespace Insidestyles\SwooleBridge\Tests\Builder;

use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Request as SfRequest;

class RequestBuilderFactoryTest extends BaseTestCase
{
    /**
     * @var RequestBuilderFactory
     */
    private $instance;

    protected function setUp()
    {
        $this->instance = new RequestBuilderFactory();
    }

    /**
     * @group builder
     */
    public function testCreateSymfonyRequest()
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleRequest->header = [];
        $swooleRequest->server = [];
        $swooleRequest->expects($this->once())->method('rawContent')
            ->willReturn('');
        $res = $this->instance->createSymfonyRequest($swooleRequest);
        $this->assertInstanceOf(SfRequest::class, $res);
    }

    /**
     * @group builder
     */
    public function testCreateZendExpressiveRequest()
    {
        $swooleRequest = $this->mockSwooleRequest();
        $swooleRequest->header = [];
        $swooleRequest->server = [];
        $swooleRequest->expects($this->once())->method('rawContent')
            ->willReturn('');
        $res = $this->instance->createZendExpressiveRequest($swooleRequest);
        $this->assertInstanceOf(ServerRequestInterface::class, $res);
    }
}
