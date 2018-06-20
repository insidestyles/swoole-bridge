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
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Psr15SymfonyKernel
 * @package Insidestyles\SwooleBridge\Adapter
 */
class Psr15SymfonyKernel implements RequestHandlerInterface
{
    /**
     * @var HttpKernelInterface
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
     * Psr15SymfonyKernel constructor.
     * @param HttpKernelInterface $symfonyMiddleware
     * @param HttpFoundationFactoryInterface|null $httpFoundationFactory
     * @param HttpMessageFactoryInterface|null $httpMessageFactory
     */
    public function __construct(
        HttpKernelInterface $symfonyMiddleware,
        HttpFoundationFactoryInterface $httpFoundationFactory = null,
        HttpMessageFactoryInterface $httpMessageFactory = null
    ) {
        $this->symfonyMiddleware = $symfonyMiddleware;
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