<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

use Generated\Shared\Transfer\SevensendersTokenTransfer;

interface SevensendersFacadeInterface
{
    public function handleOrderEvent(int $idSalesOrder): string;

    public function handleShipmentEvent(int $idSalesOrder): string;

    public function isLastResponseSuccessful($idSalesOrder): bool;

    public function isTokenValid(SevensendersTokenTransfer $transfer): bool;
}
