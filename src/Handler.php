<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge;

use Insidestyles\SwooleBridge\Adapter\SwooleAdapterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

/**
 * Class SwooleResponseEmitter
 * @package Insidestyles\SwooleBridge\Emiter
 */
class Handler implements SwooleBridgeInterface
{
    /**
     * @var SwooleAdapterInterface
     */
    private $adapter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Handler constructor.
     * @param SwooleAdapterInterface $adapter
     * @param null|LoggerInterface $logger
     */
    public function __construct(
        SwooleAdapterInterface $adapter,
        ?LoggerInterface $logger = null
    ) {
        $this->adapter = $adapter;
        $this->logger = $logger ?? new NullLogger();
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
