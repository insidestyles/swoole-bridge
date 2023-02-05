<?php

namespace Insidestyles\SwooleBridge\Adapter;

use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
abstract class AbstractAdapter implements SwooleAdapterInterface
{
    public function __construct(
        protected readonly SwooleResponseEmitterInterface $responseEmitter,
        protected readonly RequestHandlerInterface $requestHandler,
        protected readonly RequestBuilderFactory $requestBuilderFactory
    ) {
    }

    /**
     * @inheritdoc
     */
    public function handle(SwooleRequest $swooleRequest, SwooleResponse $swooleResponse): void
    {
        $this->before($swooleRequest);
        $psrServerRequest = $this->requestBuilderFactory->createServerRequest($swooleRequest);
        $psrResponse = $this->requestHandler->handle($psrServerRequest);
        $this->after($psrResponse);
        $this->responseEmitter->toSwoole($psrResponse, $swooleResponse);
    }

    /**
     * @param SwooleRequest $swooleRequest
     */
    protected function before(SwooleRequest $swooleRequest)
    {
        //optional
    }

    /**
     * @param ResponseInterface $response
     */
    protected function after(ResponseInterface $response)
    {
        //optional
    }
}