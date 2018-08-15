<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler;

class OrderHandler implements HandlerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function handle(int $idSalesOrder): string
    {
        return 'true';
    }
}
