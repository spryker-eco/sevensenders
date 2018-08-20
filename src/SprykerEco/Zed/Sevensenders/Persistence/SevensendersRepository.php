<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Generated\Shared\Transfer\SevensendersTokenTransfer;

/**
 * @method \SprykerEco\Zed\Sevensenders\Persistence\SevensendersPersistenceFactory getFactory()
 */
class SevensendersRepository implements SevensendersRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function getResponseByOrderId(int $idSalesOrder): SevensendersResponseTransfer
    {
        $spyResponse = $this->getFactory()
            ->createSpySevensendersResponseQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->findOne();

        $transfer = new SevensendersResponseTransfer();

        $transfer->setRequestPayload($spyResponse->getRequestPayload());
        $transfer->setResponsePayload($spyResponse->getResponsePayload());
        $transfer->setStatus($spyResponse->getResponseStatus());

        return $transfer;
    }

    /**
     * @return \Generated\Shared\Transfer\SevensendersTokenTransfer
     */
    public function getAccessToken(): SevensendersTokenTransfer
    {
        $spyToken = $this->getFactory()
            ->createSpySevensendersTokenQuery()
            ->findOne();

        $transfer = new SevensendersTokenTransfer();
        $transfer->setUnixTimestamp($spyToken->getCreatedAt());
        $transfer->setToken($spyToken->getToken());

        return $transfer;
    }
}
