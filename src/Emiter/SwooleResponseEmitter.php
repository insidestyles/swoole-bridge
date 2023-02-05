<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Emiter;

use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Response as SwooleResponse;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
final class SwooleResponseEmitter implements SwooleResponseEmitterInterface
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

    protected function sendResponse(
        ResponseInterface $psr7Response,
        SwooleResponse $swooleResponse
    ) {
        $content = $psr7Response->getBody();
        $content->rewind();
        $res = $content->getContents();
        if (!empty($res)) {
            $swooleResponse->write($res);
        }
    }
}
