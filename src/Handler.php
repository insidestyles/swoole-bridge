<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge;

use Insidestyles\SwooleBridge\Adapter\SwooleAdapterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
final class Handler implements SwooleBridgeInterface
{
    public function __construct(
        private readonly SwooleAdapterInterface $adapter,
        private readonly ?LoggerInterface $logger = new NullLogger()
    ) {
    }

    /**
     * @inheritdoc
     */
    public function handle(
        SwooleRequest $swooleRequest,
        SwooleResponse $swooleResponse
    ): void {
        try {
            $this->adapter->handle($swooleRequest, $swooleResponse);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
