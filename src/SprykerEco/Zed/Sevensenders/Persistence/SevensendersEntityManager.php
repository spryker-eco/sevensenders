<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerEco\Zed\Sevensenders\Persistence\SevensendersPersistenceFactory getFactory()
 */
class SevensendersEntityManager extends AbstractEntityManager implements SevensendersEntityManagerInterface
{
    public const STATUS_CREATED = 201;
    public const STATUS_RESOURCE_NOT_FOUND = 404;
    public const STATUS_INVALID_INPUT = 400;

    protected const KEY_IRI = 'iri';

    /**
     * @param \Generated\Shared\Transfer\SevensendersResponseTransfer $transfer
     * @param string $resource
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function createSevensendersResponse(SevensendersResponseTransfer $transfer, string $resource): SevensendersResponseTransfer
    {
        $entity = $this->getFactory()
            ->createSpySevensendersResponseQuery()
            ->filterByResourceType($resource)
            ->filterByFkSalesOrder($transfer->getRequestPayload()['order_id'])
            ->findOneOrCreate();

        $entity->setRequestPayload(json_encode($transfer->getRequestPayload()));
        $entity->setResponseStatus($transfer->getStatus());
        $entity->setResourceType($resource);
        $entity->setFkSalesOrder($transfer->getRequestPayload()['order_id']);
        $entity->setResponsePayload(json_encode($transfer->getResponsePayload()));

        if ($transfer->getStatus() === static::STATUS_CREATED) {
            $entity->setIri($transfer->getResponsePayload()[static::KEY_IRI]);
        }

        $entity->save();

        return $transfer;
    }
}
