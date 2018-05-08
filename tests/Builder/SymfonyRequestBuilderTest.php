<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 08.05.18
 * Time: 9:31
 */

namespace Insidestyles\SwooleBridge\Tests\Builder;

use Insidestyles\SwooleBridge\Builder\SymfonyRequestBuilder;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use Swoole\Http\Request as SwooleRequest;
use Symfony\Component\HttpFoundation\Request as SfRequest;

class SymfonyRequestBuilderTest extends BaseTestCase
{
    /**
     * @var SymfonyRequestBuilder
     */
    private $instance;

    protected function setUp()
    {
        $this->instance = new SymfonyRequestBuilder();
    }

    /**
     * @group builder
     */
    public function testBuild()
    {
        /** @var SwooleRequest|\PHPUnit_Framework_MockObject_MockObject $swooleRequest */
        $swooleRequest = $this->mockSwooleRequest();
        $swooleRequest->header = [
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
        ];
        $swooleRequest->server = [
            'REQUEST_METHOD' => 'GET',
            'TRUSTED_PROXIES' => '127.0.0.1',
            'TRUSTED_HOSTS' => 'test.com',
        ];
        $swooleRequest->get = ['query'];
        $swooleRequest->post = ['request'];
        $swooleRequest->cookie = ['cookie'];
        $swooleRequest->files = [];
        $swooleRequest->expects($this->once())->method('rawContent')
            ->willReturn('raw content');
        $this->instance->build($swooleRequest);
        $res = $this->instance->getRequest();
        $this->assertInstanceOf(SfRequest::class, $res);
        $this->assertEquals(['content-type' => ['application/x-www-form-urlencoded']], $res->headers->all());
        $this->assertEquals(['query'], $res->query->all());
        $this->assertEquals(['request'], $res->request->all());
        $this->assertEquals(['cookie'], $res->cookies->all());
        $this->assertEquals([
            'REQUEST_METHOD' => 'GET',
            'TRUSTED_PROXIES' => '127.0.0.1',
            'TRUSTED_HOSTS' => 'test.com',
            'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded',

        ], $res->server->all());
        $this->assertEquals('raw content', $res->getContent());
    }
}
