<?php

namespace Insidestyles\SwooleBridge\Tests\Traits;

use Swoole\Http\Request as SwooleRequest;

/**
 * Trait ObjectCreatorTrait
 * @package Insidestyles\SwooleBridge\Tests\Traits
 */
trait ObjectCreatorTrait
{
    /**
     * @param array $options
     * @return $swooleRequest
     */
    protected function createSwooleRequest(array $options = []): SwooleRequest
    {
        $swooleRequest = new SwooleRequest();
        $swooleRequest->header = [];
        $swooleRequest->server = [];

        return $swooleRequest;
    }
}