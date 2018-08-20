<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Mapper;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

class ShipmentMapper implements MapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersRequestTransfer
     */
    public function map(OrderTransfer $orderTransfer): SevensendersRequestTransfer
    {
        /**
         * @var $methodTransfer ShipmentMethodTransfer
         */
        $methodTransfer = $orderTransfer->getShipmentMethods()->offsetGet(0);

        $payload = [
            'order_id' => $orderTransfer->getIdSalesOrder(),
            'reference_number' => $orderTransfer->getOrderReference(),
            'tracking_code' => 'string',
            'package_no' => 0,
            'delivered_with_seven_senders' => true,
            'carrier' => [
                'name' => $methodTransfer->getCarrierName(),
                'country' => 'string'
            ],
            'carrier_service' => $methodTransfer->getCarrierName(),
            'recipient_first_name' => $orderTransfer->getShippingAddress()->getFirstName(),
            'recipient_last_name' => $orderTransfer->getShippingAddress()->getLastName(),
            'recipient_email' => $orderTransfer->getShippingAddress()->getEmail(),
            'recipient_address' =>  $orderTransfer->getShippingAddress()->getAddress1() . $orderTransfer->getShippingAddress()->getAddress2() . $orderTransfer->getShippingAddress()->getAddress3(),
            'recipient_zip' => $orderTransfer->getShippingAddress()->getZipCode(),
            'recipient_city' => $orderTransfer->getShippingAddress()->getCity(),
            'recipient_country' => $orderTransfer->getShippingAddress()->getCountry(),
            'recipient_phone' => $orderTransfer->getShippingAddress()->getPhone(),
            'recipient_company_name' => $orderTransfer->getShippingAddress()->getCompany(),
            'sender_first_name' => 'string',
            'sender_last_name' => 'string',
            'sender_company_name' => 'string',
            'sender_street' => 'string',
            'sender_house_no' => 'string',
            'sender_zip' => 'string',
            'sender_city' => 'string',
            'sender_country' => 'string',
            'sender_phone' => 'string',
            'sender_email' => 'string',
            'cod' => true,
            'cod_value' => 0,
            'return_parcel' => true,
            'pickup_point_selected' => true,
            'weight' => 0,
            'planned_pickup_datetime' => $methodTransfer->getDeliveryTime(),
            'comment' => 'string',
            'warehouse_address' => 'string',
            'warehouse' => 'string'
        ];

        $transfer = new SevensendersRequestTransfer();
        $transfer->setPayload($payload);

        return $transfer;
    }
}
