<?php

namespace Insidestyles\SwooleBridge\Tests\Builder;

use Insidestyles\SwooleBridge\Builder\ServerRequestBuilder;
use Insidestyles\SwooleBridge\Tests\Base\BaseTestCase;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\MockObject\MockObject;
use Swoole\Http\Request as SwooleRequest;

class ServerRequestBuilderTest extends BaseTestCase
{
    private ServerRequestBuilder $instance;

    protected function setUp(): void
    {
        $this->instance = new ServerRequestBuilder();
    }

    /**
     * @group builder
     */
    public function testBuild(): void
    {
        /** @var SwooleRequest|MockObject$swooleRequest */
        $swooleRequest = $this->mockSwooleRequest();
        $swooleRequest->header = [
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
        ];
        $swooleRequest->server = [
            'REQUEST_METHOD' => 'GET',
            'USER' => 'root',
            'HTTP_CACHE_CONTROL' => '',
            'HTTP_UPGRADE_INSECURE_REQUESTS' => '',
            'HTTP_CONNECTION' => '',
            'HTTP_DNT' => '',
            'HTTP_ACCEPT_ENCODING' => '',
            'HTTP_ACCEPT_LANGUAGE' => '',
            'HTTP_ACCEPT' => '',
            'HTTP_USER_AGENT' => '',
            'HTTP_HOST' => '',
            'SERVER_NAME' => '_',
            'SERVER_PORT' => null,
            'SERVER_ADDR' => '',
            'REMOTE_PORT' => null,
            'REMOTE_ADDR' => '',
            'SERVER_SOFTWARE' => '',
            'GATEWAY_INTERFACE' => '',
            'REQUEST_SCHEME' => 'http',
            'SERVER_PROTOCOL' => null,
            'DOCUMENT_ROOT' => false,
            'DOCUMENT_URI' => '/',
            'REQUEST_URI' => '',
            'SCRIPT_NAME' => '/swoole-expressive',
            'CONTENT_LENGTH' => null,
            'CONTENT_TYPE' => null,
            'QUERY_STRING' => '',
            'SCRIPT_FILENAME' => '//swoole-expressive',
            'PATH_INFO' => '',
            'FCGI_ROLE' => 'RESPONDER',
            'PHP_SELF' => '',
            'REQUEST_TIME_FLOAT' => '',
            'REQUEST_TIME' => '',

        ];
        $swooleRequest->get = ['query'];
        $swooleRequest->post = ['request'];
        $swooleRequest->cookie = ['cookie'];
        $swooleRequest->files = [];
        $swooleRequest->expects($this->once())->method('rawContent')
            ->willReturn('raw content');
        $this->instance->build($swooleRequest);
        $res = $this->instance->getRequest();
        $this->assertInstanceOf(ServerRequest::class, $res);
        $this->assertEquals(['CONTENT_TYPE' => ['application/x-www-form-urlencoded']], $res->getHeaders());
        $this->assertEquals(['query'], $res->getQueryParams());
        $this->assertEquals(['cookie'], $res->getCookieParams());
        $this->assertEquals($swooleRequest->server, $res->getServerParams());
    }
}
