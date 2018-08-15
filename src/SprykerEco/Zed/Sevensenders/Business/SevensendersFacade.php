<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Sevensenders\Business\SevensendersBusinessFactory getFactory()
 */
class SevensendersFacade extends AbstractFacade implements SevensendersFacadeInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleOrderEvent(int $idSalesOrder): string
    {
       return $this->getFactory()
           ->createOrderHandler()
           ->handle($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handleShipmentEvent(int $idSalesOrder): string
    {
        return $this->getFactory()
            ->createShipmentHandler()
            ->handle($idSalesOrder);
    }
}
