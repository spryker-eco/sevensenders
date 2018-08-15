<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Api\Adapter;

use Generated\Shared\Transfer\SevensendersRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException;
use SprykerEco\Zed\Sevensenders\SevensendersConfig;

class SevensendersApiAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;

    public const ORDER_RESOURCE = 'orders';
    public const SHIPMENT_RESOURCE ='shipments';
    public const AUTH_RESOURCE ='token';


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
     * @param \SprykerEco\Zed\Sevensenders\SevensendersConfig $config
     */
    public function __construct(SevensendersConfig $config)
    {
        $this->config = $config;
        $this->client = new Client([
            RequestOptions::TIMEOUT => static::DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $transfer
     * @param string $resource
     *
     * @throws SevensendersApiHttpRequestException
     *
     * @return StreamInterface|string
     */
    public function sendRequest(SevensendersRequestTransfer $transfer, string $resource)
    {
        $options[RequestOptions::BODY] = json_encode($transfer->toArray());
        $options[RequestOptions::HEADERS] = static::DEFAULT_HEADERS;
        $options[RequestOptions::AUTH] = [$this->config->getInxmailKeyId(), $this->config->getInxmailSecret()];

        return $this->send($options);
    }

    /**
     * @param array $options
     * @param string $resource
     *
     * @throws SevensendersApiHttpRequestException
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function send(string $resource, array $options = []): StreamInterface
    {
        try {
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

        return $response->getBody();
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