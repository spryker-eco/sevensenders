<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Generated\Shared\Transfer\SevensendersTokenTransfer;

interface SevensendersRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function getResponseByOrderId(int $idSalesOrder): SevensendersResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\SevensendersTokenTransfer
     */
    public function getAccessToken(): SevensendersTokenTransfer;
}
