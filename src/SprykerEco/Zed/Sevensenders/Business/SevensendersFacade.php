<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

use Generated\Shared\Transfer\SevensendersTokenTransfer;
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

    /**
     * @param $idSalesOrder
     *
     * @return bool
     */
    public function isLastResponseSuccessful($idSalesOrder): bool
    {
        return $this->getFactory()
            ->createResponseHelper()
            ->isLastResponseSuccessful($idSalesOrder);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersTokenTransfer $tokenTransfer
     *
     * @return bool
     */
    public function isTokenValid(SevensendersTokenTransfer $tokenTransfer): bool
    {
        return $this->getFactory()
            ->createTokenHelper()
            ->isTokenValid($tokenTransfer);
    }
}
