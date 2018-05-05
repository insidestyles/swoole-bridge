<?php
/**
 * User: insidestyles
 * Date: 05.05.18
 * Time: 8:25
 */

namespace Insidestyles\SwooleBridge\Builder;

use Psr\Http\Message\RequestInterface;
use Swoole\Http\Request as SwooleRequest;


/**
 * Interface RequestBuilderInterface
 * @package Insidestyles\SwooleBridge\Builder
 */
interface RequestBuilderInterface
{
    /**
     * @param SwooleRequest $swooleRequest
     */
    public function build(SwooleRequest $swooleRequest);

    /**
     * @return mixed
     */
    public function getRequest();
}