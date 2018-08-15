<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 20.06.18
 * Time: 10:06
 */

namespace Insidestyles\SwooleBridge\Adapter\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Illuminate\Contracts\Http\Kernel;

/**
 * Class Psr15IllumimateKernel
 * @package Insidestyles\SwooleBridge\Adapter
 */
class Psr15IllumimateKernel implements RequestHandlerInterface
{
    /**
     * @var Kernel
     */
    private $httpKernel;

    /**
     * @var HttpMessageFactoryInterface
     */
    private $httpMessageFactory;

    /**
     * @var HttpFoundationFactoryInterface
     */
    private $httpFoundationFactory;

    /**
     * Psr15IllumimateKernel constructor.
     * @param Kernel $httpKernel
     * @param HttpFoundationFactoryInterface|null $httpFoundationFactory
     * @param HttpMessageFactoryInterface|null $httpMessageFactory
     */
    public function __construct(
        Kernel $httpKernel,
        HttpFoundationFactoryInterface $httpFoundationFactory = null,
        HttpMessageFactoryInterface $httpMessageFactory = null
    ) {
        $this->httpKernel = $httpKernel;
        $this->httpFoundationFactory = $httpFoundationFactory ?: new HttpFoundationFactory();
        $this->httpMessageFactory = $httpMessageFactory ?: new DiactorosFactory();
    }

    /**
     * Handle the request and return a response.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $symfonyRequest = $this->httpFoundationFactory->createRequest($request);
        $symfonyResponse = $this->httpKernel->handle($symfonyRequest);

        return $this->httpMessageFactory->createResponse($symfonyResponse);
    }

}