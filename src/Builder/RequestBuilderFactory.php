<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Builder;

use Psr\Http\Message\ServerRequestInterface;
use Swoole\Http\Request as SwooleRequest;

/**
 * @author Fuong <insidestyles@gmail.com>
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
    
    protected function createRequest(SwooleRequest $swooleRequest, string $builderClass): ServerRequestInterface
    {
        /** @var RequestBuilderInterface $builder */
        $builder = new $builderClass();
        $builder->build($swooleRequest);

        return $builder->getRequest();
    }
}
