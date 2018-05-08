<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Builder;

use Psr\Http\Message\ServerRequestInterface;
use Swoole\Http\Request as SwooleRequest;
use Symfony\Component\HttpFoundation\Request as SfRequest;

/**
 * Class RequestBuilderFactory
 * @package Insidestyles\SwooleBridge\Builder
 */
class RequestBuilderFactory
{
    /**
     * @param SwooleRequest $swooleRequest
     * @return SfRequest
     */
    public function createSymfonyRequest(SwooleRequest $swooleRequest): SfRequest
    {
        return $this->createRequest($swooleRequest, SymfonyRequestBuilder::class);
    }

    /**
     * @param SwooleRequest $swooleRequest
     * @return ServerRequestInterface
     */
    public function createZendExpressiveRequest(SwooleRequest $swooleRequest): ServerRequestInterface
    {
        return $this->createRequest($swooleRequest, ZendExpressiveRequestBuilder::class);
    }

    /**
     * @param SwooleRequest $swooleRequest
     * @param string $builderClass
     * @return mixed
     */
    public function createRequest(SwooleRequest $swooleRequest, string $builderClass)
    {
        $builder = new $builderClass();

        return $this->makeRequest($swooleRequest, $builder);
    }

    /**
     * @param RequestBuilderInterface $requestBuilder
     * @param SwooleRequest $swooleRequest
     * @return mixed
     */
    private function makeRequest(SwooleRequest $swooleRequest, RequestBuilderInterface $requestBuilder)
    {
        $requestBuilder->build($swooleRequest);

        return $requestBuilder->getRequest();
    }
}
