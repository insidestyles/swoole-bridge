<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 05.05.18
 * Time: 10:30
 */

namespace Insidestyles\SwooleBridge\Emiter;

use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Response as SwooleResponse;


/**
 * Class SwooleResponseEmitter
 * @package Insidestyles\SwooleBridge\Emiter
 */
interface SwooleResponseEmitterInterface
{
    /**
     * @param ResponseInterface $psr7Response
     * @param SwooleResponse $swooleResponse
     */
    public function toSwoole(ResponseInterface $psr7Response, SwooleResponse $swooleResponse): void;
}