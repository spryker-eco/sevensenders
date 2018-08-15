<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Api\Adapter;

use Generated\Shared\Transfer\SevenSendersRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Inxmail\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException;
use SprykerEco\Zed\Sevensenders\SevensendersConfig;

abstract class AbstractAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;

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
     * @return string
     */
    abstract protected function getUrl(): string;

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
     * @param \Generated\Shared\Transfer\SevenSendersRequestTransfer $transfer
     *
     * @return mixed
     */
    public function sendRequest(SevenSendersRequestTransfer $transfer)
    {
        $options[RequestOptions::BODY] = json_encode($transfer->toArray());
        $options[RequestOptions::HEADERS] = static::DEFAULT_HEADERS;
        $options[RequestOptions::AUTH] = [$this->config->getInxmailKeyId(), $this->config->getInxmailSecret()];

        return $this->send($options);
    }

    /**
     * @param array $options
     *
     * @throws \SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function send(array $options = []): StreamInterface
    {
        try {
            $response = $this->client->post(
                $this->getUrl(),
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
}