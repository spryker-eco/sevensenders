<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\SevensendersApiAdapter;

/**
 * @method \SprykerEco\Zed\Sevensenders\Persistence\SevensendersPersistenceFactory getFactory()
 */
class SevensendersRepository extends AbstractRepository implements SevensendersRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     * @param string $resource
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function getResponseByOrderId(int $idSalesOrder, string $resource = SevensendersApiAdapter::ORDER_RESOURCE): SevensendersResponseTransfer
    {
        $spyResponse = $this->getFactory()
            ->createSpySevensendersResponseQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByResourceType($resource)
            ->findOne();

        $transfer = new SevensendersResponseTransfer();

        $transfer->setRequestPayload($spyResponse ? json_decode($spyResponse->getRequestPayload(), true) : []);
        $transfer->setResponsePayload($spyResponse ? json_decode($spyResponse->getResponsePayload(), true) : []);
        $transfer->setStatus($spyResponse ? $spyResponse->getResponseStatus() : null);

        return $transfer;
    }
}
