<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;
use Generated\Shared\Transfer\SpySevensendersResponseEntityTransfer;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface;
use SprykerEco\Zed\Sevensenders\Dependency\Service\SevensendersToUtilEncodingServiceInterface;
use SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface;

abstract class AbstractHandler implements HandlerInterface
{
    protected const STATUS_CREATED = 201;
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
     * @var \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface
     */
    public $salesFacade;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface
     */
    public $entityManager;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Dependency\Service\SevensendersToUtilEncodingServiceInterface
     */
    public $utilEncodingService;

    /**
     * @param \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface $mapper
     * @param \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface $salesFacade
     * @param \SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface $entityManager
     * @param \SprykerEco\Zed\Sevensenders\Dependency\Service\SevensendersToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        MapperInterface $mapper,
        AdapterInterface $adapter,
        SevensendersToSalesFacadeInterface $salesFacade,
        SevensendersEntityManagerInterface $entityManager,
        SevensendersToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
        $this->salesFacade = $salesFacade;
        $this->entityManager = $entityManager;
        $this->utilEncodingService = $utilEncodingService;
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
     * @param string $resource
     *
     * @return void
     */
    protected function sendRequest(SevensendersRequestTransfer $requestTransfer, string $resource): void
    {
        $response = $this->adapter->send($requestTransfer, $resource);

        $this->saveResult($response, $resource);
    }

    /**
     * @param \Generated\Shared\Transfer\SevensendersResponseTransfer $responseTransfer
     * @param string $resource
     *
     * @return void
     */
    protected function saveResult(SevensendersResponseTransfer $responseTransfer, string $resource): void
    {
        $requestPayload = $this->utilEncodingService->decodeJson($responseTransfer->getRequestPayload());
        $responsePayload = $this->utilEncodingService->decodeJson($responseTransfer->getResponsePayload());

        $entityTransfer = new SpySevensendersResponseEntityTransfer();

        $entityTransfer->setRequestPayload($responseTransfer->getRequestPayload());
        $entityTransfer->setResponseStatus($responseTransfer->getStatus());
        $entityTransfer->setResourceType($resource);
        $entityTransfer->setFkSalesOrder($requestPayload['order_id']);
        $entityTransfer->setResponsePayload($responseTransfer->getResponsePayload());

        if ($responseTransfer->getStatus() === static::STATUS_CREATED) {
            $entityTransfer->setIri($responsePayload[static::KEY_IRI]);
        }

        $this->entityManager->createSevensendersResponse($entityTransfer, $resource);
    }
}
