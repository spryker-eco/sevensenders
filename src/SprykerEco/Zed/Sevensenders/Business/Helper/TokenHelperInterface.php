<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Helper;

use Generated\Shared\Transfer\SevensendersTokenTransfer;

interface TokenHelperInterface
{
    /**
     * @param \Generated\Shared\Transfer\SevensendersTokenTransfer $tokenTransfer
     *
     * @return bool
     */
    public function isTokenValid(SevensendersTokenTransfer $tokenTransfer): bool;
}
