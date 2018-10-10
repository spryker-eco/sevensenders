<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Mapper;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;

class ShipmentMapper implements MapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersRequestTransfer
     */
    public function map(OrderTransfer $orderTransfer): SevensendersRequestTransfer
    {
        $methodTransfer = $orderTransfer->getShipmentMethods()->offsetGet(0);

        $payload = [
            'order_id' => (string)$orderTransfer->getIdSalesOrder(),
            'reference_number' => $orderTransfer->getOrderReference(),
            'tracking_code' => '',
            'package_no' => (int)date('U'),
            'delivered_with_seven_senders' => true,
            'carrier' => [
                'name' => $methodTransfer->getCarrierName(),
                'country' => '',
            ],
            'carrier_service' => $methodTransfer->getCarrierName(),
            'recipient_first_name' => $orderTransfer->getShippingAddress()->getFirstName(),
            'recipient_last_name' => $orderTransfer->getShippingAddress()->getLastName(),
            'recipient_email' => $orderTransfer->getEmail(),
            'recipient_address' => $this->getRecipientAddress($orderTransfer),
            'recipient_zip' => $orderTransfer->getShippingAddress()->getZipCode(),
            'recipient_city' => $orderTransfer->getShippingAddress()->getCity(),
            'recipient_country' => $orderTransfer->getShippingAddress()->getCountry()->getIso2Code(),
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
        ];

        $transfer = new SevensendersRequestTransfer();
        $transfer->setPayload($payload);

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return string
     */
    protected function getRecipientAddress(OrderTransfer $orderTransfer): string
    {
        $address = $orderTransfer->getShippingAddress()->getAddress1();

        if ($orderTransfer->getShippingAddress()->getAddress2()) {
            $address .= ', ' . $orderTransfer->getShippingAddress()->getAddress2();
        }

        if ($orderTransfer->getShippingAddress()->getAddress3()) {
            $address .= ', ' . $orderTransfer->getShippingAddress()->getAddress3();
        }

        return $address;
    }
}
