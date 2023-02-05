<?php

namespace Insidestyles\SwooleBridge\Tests\Traits;

use Swoole\Http\Request as SwooleRequest;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
trait ObjectCreatorTrait
{
    protected function createSwooleRequest(array $options = []): SwooleRequest
    {
        $swooleRequest = new SwooleRequest();
        $swooleRequest->header = [];
        $swooleRequest->server = [];

        return $swooleRequest;
    }
}