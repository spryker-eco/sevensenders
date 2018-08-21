<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

use Generated\Shared\Transfer\SevensendersTokenTransfer;

interface SevensendersFacadeInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleOrderEvent(int $idSalesOrder): string;

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleShipmentEvent(int $idSalesOrder): string;

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isLastResponseSuccessful(int $idSalesOrder): bool;

    /**
     * @param \Generated\Shared\Transfer\SevensendersTokenTransfer $transfer
     *
     * @return bool
     */
    public function isTokenValid(SevensendersTokenTransfer $transfer): bool;
}
