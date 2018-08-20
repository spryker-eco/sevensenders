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
use SprykerEco\Zed\Sevensenders\Business\Helper\TokenHelperInterface;
use SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface;

class AuthHandler implements AuthHandlerInterface
{
    protected const KEY_ACCESS_KEY = 'access_key';

    /**
     * @var \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface
     */
    public $adapter;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface
     */
    public $sevensendersRepository;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Business\Helper\TokenHelperInterface
     */
    public $tokenHelper;

    /**
     * @param \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Sevensenders\Business\Helper\TokenHelperInterface $tokenHelper
     * @param \SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface $sevensendersRepository
     */
    public function __construct(
        AdapterInterface $adapter,
        TokenHelperInterface $tokenHelper,
        SevensendersRepositoryInterface $sevensendersRepository
    ) {
        $this->adapter = $adapter;
        $this->tokenHelper = $tokenHelper;
        $this->sevensendersRepository = $sevensendersRepository;
    }

    /**
     * @return void
     */
    public function auth(): void
    {
        $tokenTransfer = $this->sevensendersRepository->getAccessToken();
        if (!$this->tokenHelper->isTokenValid($tokenTransfer)) {
            $responseTransfer = $this->sendRequest($this->prepareRequestTransfer());
            $this->saveResult($responseTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    protected function sendRequest(SevensendersRequestTransfer $requestTransfer): SevensendersResponseTransfer
    {
        $transfer = new SevensendersResponseTransfer();
        $transfer->setResponsePayload(json_decode($this->adapter->sendRequest($requestTransfer, SevensendersApiAdapter::ORDER_RESOURCE),  true));

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersResponseTransfer $responseTransfer
     *
     * @return void
     */
    protected function saveResult(SevensendersResponseTransfer $responseTransfer): void
    {
        $payload = $responseTransfer->getResponsePayload();

        if (array_key_exists(static::KEY_ACCESS_KEY, $payload)) {
            $entity = new SpySevensendersToken();
            $entity->setToken($payload[static::KEY_ACCESS_KEY]);
            $entity->save();
        }
    }

    /**
     * @return \Generated\Shared\Transfer\SevensendersRequestTransfer
     */
    protected function prepareRequestTransfer(): SevensendersRequestTransfer
    {
        return new SevensendersRequestTransfer();
    }
}
