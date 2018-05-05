<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 05.05.18
 * Time: 10:41
 */

namespace Insidestyles\SwooleBridge\Adapter;

use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ApplicationAdapterInterface
 * @package Insidestyles\SwooleBridge\Adapter
 */
interface SwooleAdapterInterface
{
    /**
     * @param SwooleRequest $request
     * @return ResponseInterface
     */
    public function handle(SwooleRequest $request, SwooleResponse $swooleResponse) : void;
}