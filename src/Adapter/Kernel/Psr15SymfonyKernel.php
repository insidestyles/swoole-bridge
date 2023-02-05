<?php

namespace Insidestyles\SwooleBridge\Adapter\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
class Psr15SymfonyKernel implements RequestHandlerInterface
{
    public function __construct(
        private readonly HttpKernelInterface $httpKernel,
        private readonly HttpFoundationFactoryInterface $httpFoundationFactory,
        private readonly HttpMessageFactoryInterface $httpMessageFactory,
    ) {
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