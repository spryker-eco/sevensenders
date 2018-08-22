<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Communication\Plugin\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \SprykerEco\Zed\Sevensenders\Business\SevensendersFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Sevensenders\Communication\SevensendersCommunicationFactory getFactory()
 */
class IsSuccessfulPreviousShipmentResponseConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        return $this->getFacade()->isLastOrderResponseSuccessful($orderItem->getOrder()->getIdSalesOrder());
    }
}
