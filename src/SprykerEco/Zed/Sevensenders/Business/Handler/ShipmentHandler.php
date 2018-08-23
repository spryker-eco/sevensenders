<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler;

use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\SevensendersApiAdapter;

class ShipmentHandler extends AbstractHandler
{
    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handle(int $idSalesOrder): void
    {
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $requestTransfer = $this->map($orderTransfer);

        $this->sendRequest($requestTransfer, SevensendersApiAdapter::SHIPMENT_RESOURCE);
    }
}
