<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Sevensenders\Business\Api\Adapter\SevensendersApiAdapter;
use SprykerEco\Zed\Sevensenders\Business\Handler\HandlerInterface;
use SprykerEco\Zed\Sevensenders\Business\Handler\OrderHandler;
use SprykerEco\Zed\Sevensenders\Business\Handler\ShipmentHandler;
use SprykerEco\Zed\Sevensenders\Business\Helper\OrderResponseHelper;
use SprykerEco\Zed\Sevensenders\Business\Helper\ResponseHelperInterface;
use SprykerEco\Zed\Sevensenders\Business\Helper\ShipmentResponseHelper;
use SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Sevensenders\Business\Mapper\OrderMapper;
use SprykerEco\Zed\Sevensenders\Business\Mapper\ShipmentMapper;
use SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface;
use SprykerEco\Zed\Sevensenders\SevensendersDependencyProvider;

/**
 * @method \SprykerEco\Zed\Sevensenders\SevensendersConfig getConfig()
 * @method \SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface getRepository()()
 */
class SevensendersBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Handler\HandlerInterface
     */
    public function createOrderHandler(): HandlerInterface
    {
        return new OrderHandler(
            $this->createOrderMapper(),
            $this->createSevensendersApiAdapter(),
            $this->getFacadeSales()
        );
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Handler\HandlerInterface
     */
    public function createShipmentHandler(): HandlerInterface
    {
        return new ShipmentHandler(
            $this->createShipmentMapper(),
            $this->createSevensendersApiAdapter(),
            $this->getFacadeSales()
        );
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Helper\ResponseHelperInterface
     */
    public function createOrderResponseHelper(): ResponseHelperInterface
    {
        return new OrderResponseHelper($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Helper\ResponseHelperInterface
     */
    public function createShipmentResponseHelper(): ResponseHelperInterface
    {
        return new ShipmentResponseHelper($this->getRepository());
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface
     */
    protected function createOrderMapper(): MapperInterface
    {
        return new OrderMapper();
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Mapper\MapperInterface
     */
    protected function createShipmentMapper(): MapperInterface
    {
        return new ShipmentMapper();
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Dependency\Facade\SevensendersToSalesFacadeInterface
     */
    protected function getFacadeSales(): SevensendersToSalesFacadeInterface
    {
        return $this->getProvidedDependency(SevensendersDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Sevensenders\Business\Api\Adapter\AdapterInterface
     */
    protected function createSevensendersApiAdapter(): AdapterInterface
    {
        return new SevensendersApiAdapter($this->getConfig());
    }
}
