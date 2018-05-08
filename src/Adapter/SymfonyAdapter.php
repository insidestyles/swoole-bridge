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
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class SymfonyAdapter
 * @package Insidestyles\SwooleBridge\Adapter
 */
class SymfonyAdapter implements SwooleAdapterInterface
{
    /**
     * @var Kernel
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
     * @var DiactorosFactory
     */
    private $psr7Factory;

    /**
     * SymfonyAdapter constructor.
     * @param Kernel $app
     * @param SwooleResponseEmitterInterface $responseEmitter
     * @param RequestBuilderFactory $requestBuilder
     */
    public function __construct(
        Kernel $app,
        SwooleResponseEmitterInterface $responseEmitter,
        RequestBuilderFactory $requestBuilder,
        DiactorosFactory $psr7Factory
    ) {
        $this->app = $app;
        $this->requestBuilderFactory = $requestBuilder;
        $this->responseEmitter = $responseEmitter;
        $this->psr7Factory = $psr7Factory;
    }

    /**
     * @inheritdoc
     */
    public function handle(SwooleRequest $swooleRequest, SwooleResponse $swooleResponse): void
    {
        $sfRequest = $this->requestBuilderFactory->createSymfonyRequest($swooleRequest);
        $sfResponse = $this->app->handle($sfRequest);
        $psrResponse = $this->psr7Factory->createResponse($sfResponse);
        $this->responseEmitter->toSwoole($psrResponse, $swooleResponse);
    }
}