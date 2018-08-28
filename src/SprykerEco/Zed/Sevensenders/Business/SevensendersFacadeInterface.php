<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isLastShipmentResponseSuccessful(int $idSalesOrder): bool;
}
