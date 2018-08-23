<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface;
use SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface;

abstract class AbstractHandler implements HandlerInterface
{
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
     * @param \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface $mapper
     * @param \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface $salesFacade
     * @param \SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface $entityManager
     */
    public function __construct(
        MapperInterface $mapper,
        AdapterInterface $adapter,
        SevensendersToSalesFacadeInterface $salesFacade,
        SevensendersEntityManagerInterface $entityManager
    ) {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
        $this->salesFacade = $salesFacade;
        $this->entityManager = $entityManager;
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
    protected function saveResult(SevensendersResponseTransfer $responseTransfer, string $resource)
    {
        $this->entityManager->createSevensendersResponse($responseTransfer, $resource);
    }
}
