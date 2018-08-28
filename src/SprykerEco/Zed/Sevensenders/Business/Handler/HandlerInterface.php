<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler;

interface HandlerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handle(int $idSalesOrder): void;
}
