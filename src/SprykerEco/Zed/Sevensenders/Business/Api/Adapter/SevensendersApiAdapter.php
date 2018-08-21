<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Api\Adapter;

use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException;
use SprykerEco\Zed\Sevensenders\Business\Handler\Auth\AuthHandlerInterface;
use SprykerEco\Zed\Sevensenders\SevensendersConfig;

class SevensendersApiAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;

    public const ORDER_RESOURCE = 'orders';
    public const SHIPMENT_RESOURCE = 'shipments';
    public const AUTH_RESOURCE = 'token';

    protected const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
    ];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \SprykerEco\Zed\Sevensenders\SevensendersConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Business\Handler\Auth\AuthHandlerInterface $authHandler
     */
    protected $authHandler;

    /**
     * @param \SprykerEco\Zed\Sevensenders\SevensendersConfig $config
     * @param \SprykerEco\Zed\Sevensenders\Business\Handler\Auth\AuthHandlerInterface $authHandler
     */
    public function __construct(SevensendersConfig $config, AuthHandlerInterface $authHandler)
    {
        $this->config = $config;
        $this->authHandler = $authHandler;
        $this->client = new Client([
            RequestOptions::TIMEOUT => static::DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $transfer
     * @param string $resource
     *
     * @return \Psr\Http\Message\StreamInterface|string
     */
    public function sendRequest(SevensendersRequestTransfer $transfer, string $resource)
    {
        $options[RequestOptions::BODY] = json_encode($transfer->toArray());
        $options[RequestOptions::HEADERS] = static::DEFAULT_HEADERS;
        $options[RequestOptions::AUTH] = [$this->config->getInxmailKeyId(), $this->config->getInxmailSecret()];

        return $this->send($options);
    }

    /**
     * @param string $resource
     * @param array $options
     *
     * @throws \SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    protected function send(string $resource, array $options = []): SevensendersResponseTransfer
    {
        try {
            $this->authHandler->auth();
            $response = $this->client->post(
                $this->getUrl($resource),
                $options
            );
        } catch (RequestException $requestException) {
            throw new SevensendersApiHttpRequestException(
                $requestException->getMessage(),
                $requestException->getCode(),
                $requestException
            );
        }

        $responseTransfer = new SevensendersResponseTransfer();
        $responseTransfer->setStatus($response->getStatusCode());
        $responseTransfer->setRequestPayload($options[RequestOptions::BODY]);
        $responseTransfer->setResponsePayload($response->getBody());

        return $responseTransfer;
    }

    /**
     * @param string $resource
     *
     * @return string
     */
    protected function getUrl(string $resource): string
    {
        return $this->config->getSevensendersUrl() . $resource;
    }
}
