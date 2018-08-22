<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Generated\Shared\Transfer\SevensendersTokenTransfer;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\SevensendersApiAdapter;

interface SevensendersRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     * @param string $resource
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function getResponseByOrderId(int $idSalesOrder, string $resource = SevensendersApiAdapter::ORDER_RESOURCE): SevensendersResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\SevensendersTokenTransfer
     */
    public function getAccessToken(): SevensendersTokenTransfer;
}
