<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Orm\Zed\Sevensenders\Persistence\SpySevensendersResponse;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\SevensendersApiAdapter;
use SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface;

class OrderHandler implements HandlerInterface
{
    protected const STATUS_ORDER_CREATED = 201;
    protected const STATUS_RESOURCE_NOT_FOUND = 404;
    protected const STATUS_INVALID_INPUT = 400;

    protected const KEY_IRI = 'iri';

    /**
     * @var \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface
     */
    public $mapper;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface
     */
    public $adapter;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeBridge
     */
    public $salesFacade;

    /**
     * @param \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface $mapper
     * @param \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface $salesFacade
     */
    public function __construct(
        MapperInterface $mapper,
        AdapterInterface $adapter,
        SevensendersToSalesFacadeInterface $salesFacade
    ) {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handle(int $idSalesOrder): string
    {
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $requestTransfer = $this->map($orderTransfer);
        $responseTransfer = $this->sendRequest($requestTransfer);
        $this->saveResult($responseTransfer);

        return 'true';
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersRequestTransfer
     */
    protected function map(OrderTransfer $orderTransfer): SevensendersRequestTransfer
    {
        return $this->mapper->map($orderTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    protected function sendRequest(SevensendersRequestTransfer $requestTransfer): SevensendersResponseTransfer
    {
        $transfer = new SevensendersResponseTransfer();
        $transfer->setResponsePayload(json_decode($this->adapter->sendRequest($requestTransfer, SevensendersApiAdapter::ORDER_RESOURCE), true));

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersResponseTransfer $responseTransfer
     *
     * @return void
     */
    protected function saveResult(SevensendersResponseTransfer $responseTransfer)
    {
        $entity = new SpySevensendersResponse();
        $entity->setRequestPayload(json_encode($responseTransfer->getRequestPayload()));
        $entity->setResponseStatus($responseTransfer->getStatus());
        $entity->setResourceType(SevensendersApiAdapter::ORDER_RESOURCE);
        $entity->setSalesOrder(1);
        $entity->setResponsePayload(json_encode($responseTransfer->getResponsePayload()));
        $entity->setIri($responseTransfer->getResponsePayload()[static::KEY_IRI]);

        $entity->save();
    }
}
