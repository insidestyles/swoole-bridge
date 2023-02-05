<?php

namespace Insidestyles\SwooleBridge;

use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;


/**
 * @author Fuong <insidestyles@gmail.com>
 */
interface SwooleBridgeInterface
{
    public function handle(SwooleRequest $swooleRequest, SwooleResponse $swooleResponse): void;
}