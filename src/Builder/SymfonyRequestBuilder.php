<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Builder;

use Swoole\Http\Request as SwooleRequest;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as SfRequest;

/**
 * Class SymfonyRequestBuilder
 * @package Insidestyles\SwooleBridge\Builder;
 */
class SymfonyRequestBuilder implements RequestBuilderInterface
{
    /**
     * @var SfRequest
     */
    private $request;

    /**
     * @inheritdoc
     */
    public function build(SwooleRequest $swooleRequest)
    {
        $headers = array_combine(array_map(function ($key) {
            return 'HTTP_' . str_replace('-', '_', $key);
        }, array_keys($swooleRequest->header)), array_values($swooleRequest->header));
        $server = array_change_key_case(array_merge($swooleRequest->server, $headers), CASE_UPPER);
        if ($trustedProxies = $server['TRUSTED_PROXIES'] ?? false) {
            SfRequest::setTrustedProxies(explode(',', $trustedProxies),
                SfRequest::HEADER_X_FORWARDED_ALL ^ SfRequest::HEADER_X_FORWARDED_HOST);
        }
        if ($trustedHosts = $server['TRUSTED_HOSTS'] ?? false) {
            SfRequest::setTrustedHosts(explode(',', $trustedHosts));
        }
        $sfRequest = new SfRequest(
            $swooleRequest->get ?? [],
            $swooleRequest->post ?? [],
            [],
            $swooleRequest->cookie ?? [],
            $swooleRequest->files ?? [],
            $server,
            $swooleRequest->rawContent()
        );
        if (0 === strpos($sfRequest->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded')
            && in_array(strtoupper($sfRequest->server->get('REQUEST_METHOD', 'GET')), ['PUT', 'DELETE', 'PATCH'], true)
        ) {
            parse_str($sfRequest->getContent(), $data);
            $sfRequest->request = new ParameterBag($data);
        }

        $this->request = $sfRequest;
    }

    /**
     * @return mixed|SfRequest
     */
    public function getRequest()
    {
        return $this->request;
    }
}
