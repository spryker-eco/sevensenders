<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Helper;

interface ResponseHelperInterface
{
    /**
     * @param int $isSalesOrder
     *
     * @return bool
     */
    public function isLastResponseSuccessful(int $isSalesOrder): bool;
}
