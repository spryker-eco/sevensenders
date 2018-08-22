<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

interface SevensendersFacadeInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleOrderEvent(int $idSalesOrder): void;

    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleShipmentEvent(int $idSalesOrder): void;

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isLastOrderResponseSuccessful(int $idSalesOrder): bool;
}
