<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Api\Adapter;

use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiBadCredentialsException;
use SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException;
use SprykerEco\Zed\Sevensenders\Dependency\Service\SevensendersToUtilEncodingServiceInterface;
use SprykerEco\Zed\Sevensenders\SevensendersConfig;

class SevensendersApiAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;

    public const ORDER_RESOURCE = 'orders';
    public const SHIPMENT_RESOURCE = 'shipments';
    public const AUTH_RESOURCE = 'token';

    protected const RESPONSE_KEY_TOKEN = 'token';

    protected const REQUEST_KEY_ACCESS_KEY = 'access_key';

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
     * @var \SprykerEco\Zed\Sevensenders\Dependency\Service\SevensendersToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \SprykerEco\Zed\Sevensenders\SevensendersConfig $config
     * @param \SprykerEco\Zed\Sevensenders\Dependency\Service\SevensendersToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(SevensendersConfig $config, SevensendersToUtilEncodingServiceInterface $utilEncodingService)
    {
        $this->config = $config;
        $this->utilEncodingService = $utilEncodingService;
        $this->client = new Client([
            RequestOptions::TIMEOUT => static::DEFAULT_TIMEOUT,
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $transfer
     * @param string $resource
     *
     * @throws \SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiHttpRequestException
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function send(SevensendersRequestTransfer $transfer, string $resource): SevensendersResponseTransfer
    {
        try {
            $options = $this->prepareOptions($transfer);
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
        $responseTransfer->setResponsePayload($response->getBody()->getContents());

        return $responseTransfer;
    }

    /**
     * @throws \SprykerEco\Zed\Sevensenders\Business\Exception\SevensendersApiBadCredentialsException
     *
     * @return string
     */
    protected function auth(): string
    {
        $response = $this->utilEncodingService->decodeJson($this->client->post($this->getUrl(static::AUTH_RESOURCE), [
            RequestOptions::BODY => $this->utilEncodingService->encodeJson([
                static::REQUEST_KEY_ACCESS_KEY => $this->config->getApiKey(),
            ]),
        ])->getBody()->getContents());

        if (!array_key_exists(static::RESPONSE_KEY_TOKEN, $response)) {
            throw new SevensendersApiBadCredentialsException('Bad credentials', 401);
        }

        return 'Bearer ' . $response[static::RESPONSE_KEY_TOKEN];
    }

    /**
     * @param string $resource
     *
     * @return string
     */
    protected function getUrl(string $resource): string
    {
        return $this->config->getApiUrl() . $resource;
    }

    /**i
     *
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $transfer
     *
     * @return array
     */
    protected function prepareOptions(SevensendersRequestTransfer $transfer): array
    {
        $options[RequestOptions::BODY] = $this->utilEncodingService->encodeJson($transfer->getPayload());
        $options[RequestOptions::HEADERS] = $this->prepareHeaders();

        return $options;
    }

    /**
     * @return array
     */
    protected function prepareHeaders(): array
    {
        $auth = [
            'Authorization' => $this->auth(),
        ];

        return array_merge(static::DEFAULT_HEADERS, $auth);
    }
}
