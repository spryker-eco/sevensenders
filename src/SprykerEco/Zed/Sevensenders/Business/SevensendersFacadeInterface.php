<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

interface SevensendersFacadeInterface
{
    public function handleOrderEvent(int $idSalesOrder): string;

    public function handleShipmentEvent(int $idSalesOrder): string;
}
