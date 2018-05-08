<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 05.05.18
 * Time: 10:49
 */

namespace Insidestyles\SwooleBridge;

use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;


/**
 * Class SwooleResponseEmitter
 * @package Insidestyles\SwooleBridge
 */
interface SwooleBridgeInterface
{
    /**
     * @param SwooleRequest $swooleRequest
     * @param SwooleResponse $swooleResponse
     */
    public function handle(SwooleRequest $swooleRequest, SwooleResponse $swooleResponse): void;
}