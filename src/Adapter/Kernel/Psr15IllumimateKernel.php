<?php

namespace Insidestyles\SwooleBridge\Adapter\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Illuminate\Contracts\Http\Kernel;

/**
 * @author Fuong <insidestyles@gmail.com>
 */
class Psr15IllumimateKernel implements RequestHandlerInterface
{

    public function __construct(
        private readonly Kernel $httpKernel,
        private readonly HttpFoundationFactoryInterface $httpFoundationFactory,
        private readonly HttpMessageFactoryInterface $httpMessageFactory,
    ) {
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $symfonyRequest = $this->httpFoundationFactory->createRequest($request);
        $symfonyResponse = $this->httpKernel->handle($symfonyRequest);

        return $this->httpMessageFactory->createResponse($symfonyResponse);
    }

}