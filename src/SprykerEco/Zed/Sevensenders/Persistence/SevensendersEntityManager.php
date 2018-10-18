<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SpySevensendersResponseEntityTransfer;
use Orm\Zed\Sevensenders\Persistence\SpySevensendersResponse;
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
     * @param \Generated\Shared\Transfer\SpySevensendersResponseEntityTransfer $transfer
     * @param string $resource
     *
     * @return \Orm\Zed\Sevensenders\Persistence\SpySevensendersResponse
     */
    public function createSevensendersResponse(SpySevensendersResponseEntityTransfer $transfer, string $resource): SpySevensendersResponse
    {
        $entity = $this->getFactory()
            ->createSpySevensendersResponseQuery()
            ->filterByResourceType($transfer->getResourceType())
            ->filterByFkSalesOrder($transfer->getFkSalesOrder())
            ->findOneOrCreate();

        $entity->setRequestPayload($transfer->getRequestPayload());
        $entity->setResponseStatus($transfer->getResponseStatus());
        $entity->setResourceType($transfer->getResourceType());
        $entity->setFkSalesOrder($transfer->getFkSalesOrder());
        $entity->setResponsePayload($transfer->getResponsePayload());
        $entity->setIri($transfer->getIri());

        $entity->save();

        return $entity;
    }
}
