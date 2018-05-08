<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 05.05.18
 * Time: 10:38
 */

namespace Insidestyles\SwooleBridge\Adapter;

use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitterInterface;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Zend\Expressive\Application;

/**
 * Class ZendExpressiveAdapter
 * @package Insidestyles\SwooleBridge\Adapter
 */
class ZendExpressiveAdapter implements SwooleAdapterInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var RequestBuilderFactory
     */
    private $requestBuilderFactory;

    /**
     * @var SwooleResponseEmitterInterface
     */
    private $responseEmitter;

    /**
     * ZendExpressiveAdapter constructor.
     * @param Application $app
     * @param SwooleResponseEmitterInterface $responseEmitter
     * @param RequestBuilderFactory $requestBuilder
     */
    public function __construct(
        Application $app,
        SwooleResponseEmitterInterface $responseEmitter,
        RequestBuilderFactory $requestBuilder
    ) {
        $this->app = $app;
        $this->requestBuilderFactory = $requestBuilder;
        $this->responseEmitter = $responseEmitter;
    }

    /**
     * @inheritdoc
     */
    public function handle(SwooleRequest $swooleRequest, SwooleResponse $swooleResponse): void
    {
        $zeRequest = $this->requestBuilderFactory->createZendExpressiveRequest($swooleRequest);
        $zeResponse = $this->app->handle($zeRequest);
        $this->responseEmitter->toSwoole($zeResponse, $swooleResponse);
    }
}