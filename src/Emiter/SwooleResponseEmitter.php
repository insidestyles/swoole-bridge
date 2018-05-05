<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Emiter;

use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Response as SwooleResponse;

/**
 * Class SwooleResponseEmitter
 * @package Insidestyles\SwooleBridge\Emiter
 */
class SwooleResponseEmitter implements SwooleResponseEmitterInterface
{

    /**
     * @inheritdoc
     */
    public function toSwoole(
        ResponseInterface $psr7Response,
        SwooleResponse $swooleResponse
    ): void {
        $swooleResponse->status($psr7Response->getStatusCode());
        $this->populateHeaders($psr7Response, $swooleResponse);
        $this->sendResponse($psr7Response, $swooleResponse);
    }

    /**
     * @param ResponseInterface $psr7Response
     * @param SwooleResponse $swooleResponse
     */
    protected function populateHeaders(
        ResponseInterface $psr7Response,
        SwooleResponse $swooleResponse
    ) {
        $headers = $psr7Response->getHeaders();

        foreach ($headers as $name => $values) {
            if ($name === 'Set-Cookie') {
                $swooleResponse->header($name, end($values));
                continue;
            }

            $swooleResponse->header($name, implode(', ', $values));
        }
    }

    /**
     * @param ResponseInterface $psr7Response
     * @param SwooleResponse $swooleResponse
     */
    protected function sendResponse(
        ResponseInterface $psr7Response,
        SwooleResponse $swooleResponse
    ) {
        $content = $psr7Response->getBody();
        $content->rewind();
        $swooleResponse->write($content->getContents());
    }
}
