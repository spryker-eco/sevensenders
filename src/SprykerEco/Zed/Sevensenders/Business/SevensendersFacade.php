<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Sevensenders\Business\SevensendersBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface getRepository()()
 */
class SevensendersFacade extends AbstractFacade implements SevensendersFacadeInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleOrderEvent(int $idSalesOrder): void
    {
        $this->getFactory()
           ->createOrderHandler()
           ->handle($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleShipmentEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createShipmentHandler()
            ->handle($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isLastOrderResponseSuccessful(int $idSalesOrder): bool
    {
        return $this->getFactory()
            ->createOrderResponseHelper()
            ->isLastResponseSuccessful($idSalesOrder);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isLastShipmentResponseSuccessful(int $idSalesOrder): bool
    {
        return $this->getFactory()
            ->createShipmentResponseHelper()
            ->isLastResponseSuccessful($idSalesOrder);
    }
}
