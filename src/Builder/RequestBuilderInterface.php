<?php

namespace Insidestyles\SwooleBridge\Builder;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoole\Http\Request as SwooleRequest;


/**
 * @author Fuong <insidestyles@gmail.com>
 */
interface RequestBuilderInterface
{
    public function build(SwooleRequest $swooleRequest): void;
    public function getRequest(): ServerRequestInterface;
}