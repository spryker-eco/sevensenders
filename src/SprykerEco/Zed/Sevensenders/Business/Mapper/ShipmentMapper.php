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
            'id' => $methodTransfer->getIdShipmentMethod(),
            'order_id' => $orderTransfer->getIdSalesOrder(),
            'reference_number' => $orderTransfer->getOrderReference(),
            'tracking_code' => '',
            'package_no' => 0,
            'delivered_with_seven_senders' => true,
            'carrier' => [
                'name' => $methodTransfer->getCarrierName(),
                'country' => '',
            ],
            'carrier_service' => $methodTransfer->getCarrierName(),
            'recipient_first_name' => $orderTransfer->getShippingAddress()->getFirstName(),
            'recipient_last_name' => $orderTransfer->getShippingAddress()->getLastName(),
            'recipient_name' => $orderTransfer->getShippingAddress()->getFirstName() . ' ' . $orderTransfer->getShippingAddress()->getLastName(),
            'recipient_email' => $orderTransfer->getShippingAddress()->getEmail(),
            'recipient_address' =>  $orderTransfer->getShippingAddress()->getAddress1() . $orderTransfer->getShippingAddress()->getAddress2() . $orderTransfer->getShippingAddress()->getAddress3(),
            'recipient_zip' => $orderTransfer->getShippingAddress()->getZipCode(),
            'recipient_city' => $orderTransfer->getShippingAddress()->getCity(),
            'recipient_country' => $orderTransfer->getShippingAddress()->getCountry(),
            'recipient_phone' => $orderTransfer->getShippingAddress()->getPhone(),
            'recipient_company_name' => $orderTransfer->getShippingAddress()->getCompany(),
            'sender_first_name' => '',
            'sender_last_name' => '',
            'sender_company_name' => '',
            'sender_street' => '',
            'sender_house_no' => '',
            'sender_zip' => '',
            'sender_city' => '',
            'sender_country' => '',
            'sender_phone' => '',
            'sender_email' => '',
            'cod' => true,
            'cod_value' => 0,
            'return_parcel' => true,
            'pickup_point_selected' => true,
            'weight' => 0,
            'planned_pickup_datetime' => $methodTransfer->getDeliveryTime(),
            'comment' => '',
            'warehouse_address' => '',
            'warehouse' => '',
            'shipment_tag' => [],
            'label_url' => '',
            'iri' => ''
        ];

        $transfer = new SevensendersRequestTransfer();
        $transfer->setPayload($payload);

        return $transfer;
    }
}