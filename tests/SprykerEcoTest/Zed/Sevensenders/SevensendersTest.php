<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Sevensenders;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\SevensendersRequestTransfer;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Handler\HandlerInterface;
use SprykerEco\Zed\Sevensenders\Business\Handler\OrderHandler;
use SprykerEco\Zed\Sevensenders\Business\Handler\ShipmentHandler;
use SprykerEco\Zed\Sevensenders\Business\Helper\OrderResponseHelper;
use SprykerEco\Zed\Sevensenders\Business\Helper\ResponseHelperInterface;
use SprykerEco\Zed\Sevensenders\Business\Helper\ShipmentResponseHelper;
use SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Sevensenders\Business\SevensendersBusinessFactory;
use SprykerEco\Zed\Sevensenders\Business\SevensendersFacade;
use SprykerEco\Zed\Sevensenders\Business\SevensendersFacadeInterface;
use SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface;
use SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface;

class SevensendersTest extends Unit
{
    /**
     * @return void
     */
    public function testHandleOrderEvent(): void
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handleOrderEvent(1));
    }

    /**
     * @return void
     */
    public function testShipmentEvent(): void
    {
        $facade = $this->prepareFacade();
        $this->assertEmpty($facade->handleShipmentEvent(1));
    }

    /**
     * @return void
     */
    public function testIsLastOrderResponseSuccessful(): void
    {
        $facade = $this->prepareFacade();

        $this->assertTrue($facade->isLastOrderResponseSuccessful(1));
        $this->assertFalse($facade->isLastOrderResponseSuccessful(2));
    }

    /**
     * @return void
     */
    public function testLastShipmentResponseSuccessful(): void
    {
        $facade = $this->prepareFacade();

        $this->assertTrue($facade->isLastShipmentResponseSuccessful(1));
        $this->assertFalse($facade->isLastShipmentResponseSuccessful(2));
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\SevensendersFacadeInterface
     */
    protected function prepareFacade(): SevensendersFacadeInterface
    {
        $facade = new SevensendersFacade();
        $facade->setFactory($this->prepareFactory());

        return $facade;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\SevensendersBusinessFactory
     */
    protected function prepareFactory(): SevensendersBusinessFactory
    {
        $factory = $this->getMockBuilder(SevensendersBusinessFactory::class)
            ->setMethods([
                'createOrderResponseHelper',
                'createShipmentResponseHelper',
                'createOrderHandler',
                'createShipmentHandler',
            ])
            ->getMock();

        $factory->method('createOrderResponseHelper')->willReturn($this->createOrderResponseHelperMock());
        $factory->method('createShipmentResponseHelper')->willReturn($this->createShipmentResponseHelperMock());
        $factory->method('createOrderHandler')->willReturn($this->createOrderHandlerMock());
        $factory->method('createShipmentHandler')->willReturn($this->createShipmentHandlerMock());

        return $factory;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Helper\ResponseHelperInterface
     */
    protected function createOrderResponseHelperMock(): ResponseHelperInterface
    {
        $helper = $this->getMockBuilder(OrderResponseHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['isLastResponseSuccessful'])
            ->getMock();

        $helper->method('isLastResponseSuccessful')->willReturnOnConsecutiveCalls(true, false);

        return $helper;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Helper\ResponseHelperInterface
     */
    protected function createShipmentResponseHelperMock(): ResponseHelperInterface
    {
        $helper = $this->getMockBuilder(ShipmentResponseHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['isLastResponseSuccessful'])
            ->getMock();

        $helper->method('isLastResponseSuccessful')->willReturnOnConsecutiveCalls(true, false);

        return $helper;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Handler\HandlerInterface
     */
    protected function createOrderHandlerMock(): HandlerInterface
    {
        $handler = $this->getMockBuilder(OrderHandler::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([
                $this->createMapperInterface(),
                $this->createAdapterInterface(),
                $this->createSalesFacadeMock(),
                $this->createEntityManagerInterface(),
            ])
            ->enableOriginalConstructor()
            ->setMethods([
                'map',
                'sendRequest',
            ])
            ->getMock();

        $handler->method('map')->willReturn(new SevensendersRequestTransfer());
        $handler->method('sendRequest')->willReturnCallback(function () {
        });

        return $handler;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Handler\HandlerInterface
     */
    protected function createShipmentHandlerMock(): HandlerInterface
    {
        $handler = $this->getMockBuilder(ShipmentHandler::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([
                $this->createMapperInterface(),
                $this->createAdapterInterface(),
                $this->createSalesFacadeMock(),
                $this->createEntityManagerInterface(),
            ])
            ->enableOriginalConstructor()
            ->setMethods([
                'map',
                'sendRequest',
            ])
            ->getMock();

        $handler->method('map')->willReturn(new SevensendersRequestTransfer());
        $handler->method('sendRequest')->willReturnCallback(function () {
        });

        return $handler;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface
     */
    protected function createSalesFacadeMock(): SevensendersToSalesFacadeInterface
    {
        $bridge = $this->getMockBuilder(SevensendersToSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'getOrderByIdSalesOrder',
            ])
            ->getMock();

        $bridge->method('getOrderByIdSalesOrder')->willReturn(new OrderTransfer());

        return $bridge;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface
     */
    protected function createMapperInterface(): MapperInterface
    {
        $mapper = $this->getMockBuilder(MapperInterface::class)
            ->getMock();

        return $mapper;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface
     */
    protected function createAdapterInterface(): AdapterInterface
    {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();

        return $adapter;
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Persistence\SevensendersEntityManagerInterface
     */
    protected function createEntityManagerInterface(): SevensendersEntityManagerInterface
    {
        $em = $this->getMockBuilder(SevensendersEntityManagerInterface::class)
            ->getMock();

        return $em;
    }
}
