<?php

namespace Insidestyles\SwooleBridge\Adapter;

use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
interface SwooleAdapterInterface
{
    public function handle(SwooleRequest $request, SwooleResponse $swooleResponse) : void;
}