<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler\Auth;

use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Orm\Zed\Sevensenders\Persistence\SpySevensendersToken;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\SevensendersApiAdapter;

class AuthHandler implements AuthHandlerInterface
{
    protected const KEY_ACCESS_KEY = 'access_key';

    /**
     * @var \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface
     */
    public $adapter;

    /**
     * @param \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return void
     */
    public function auth(): void
    {
        $requestTransfer = new SevensendersRequestTransfer();
        $responseTransfer = $this->sendRequest($requestTransfer);
        $this->saveResult($responseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    protected function sendRequest(SevensendersRequestTransfer $requestTransfer): SevensendersResponseTransfer
    {
        $transfer = new SevensendersResponseTransfer();
        $transfer->setPayload(json_decode($this->adapter->sendRequest($requestTransfer, SevensendersApiAdapter::ORDER_RESOURCE),  true));

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersResponseTransfer $responseTransfer
     *
     * @return void
     */
    protected function saveResult(SevensendersResponseTransfer $responseTransfer): void
    {
        $payload = $responseTransfer->getPayload();

        if (array_key_exists(static::KEY_ACCESS_KEY, $payload)) {
            $entity = new SpySevensendersToken();
            $entity->setToken($payload[static::KEY_ACCESS_KEY]);
            $entity->save();
        }
    }
}
