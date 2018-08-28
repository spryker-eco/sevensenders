<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Mapper;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;

class OrderMapper implements MapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersRequestTransfer
     */
    public function map(OrderTransfer $orderTransfer): SevensendersRequestTransfer
    {
        $payload = [
            'order_id' => (string)$orderTransfer->getIdSalesOrder(),
            'order_url' => '',
            'order_date' => $orderTransfer->getCreatedAt(),
            'delivered_with_seven_senders' => true,
            'boarding_complete' => true,
            'language' => $orderTransfer->getLocale() ? $orderTransfer->getLocale()->getLocaleName() : '',
            'promised_delivery_date' => $orderTransfer->getShipmentDeliveryTime(),
        ];

        $transfer = new SevensendersRequestTransfer();
        $transfer->setPayload($payload);

        return $transfer;
    }
}
