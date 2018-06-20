<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Builder;

use Psr\Http\Message\ServerRequestInterface;
use Swoole\Http\Request as SwooleRequest;

/**
 * Class RequestBuilderFactory
 * @package Insidestyles\SwooleBridge\Builder
 */
class RequestBuilderFactory
{

    /**
     * @param SwooleRequest $swooleRequest
     * @return ServerRequestInterface
     */
    public function createServerRequest(SwooleRequest $swooleRequest): ServerRequestInterface
    {
        return $this->createRequest($swooleRequest, ServerRequestBuilder::class);
    }

    /**
     * @param SwooleRequest $swooleRequest
     * @param string $builderClass
     * @return mixed
     */
    protected function createRequest(SwooleRequest $swooleRequest, string $builderClass): ServerRequestInterface
    {
        /** @var RequestBuilderInterface $builder */
        $builder = new $builderClass();
        $builder->build($swooleRequest);

        return $builder->getRequest();
    }
}
