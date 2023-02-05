<?php

namespace Insidestyles\SwooleBridge\Emiter;

use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Response as SwooleResponse;


/**
 * @author Fuong <insidestyles@gmail.com>
 */
interface SwooleResponseEmitterInterface
{
    public function toSwoole(ResponseInterface $psr7Response, SwooleResponse $swooleResponse): void;
}