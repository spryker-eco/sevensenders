<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SevensendersResponseTransfer;

interface SevensendersEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\SevensendersResponseTransfer $transfer
     * @param string $resource
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function createSevensendersResponse(SevensendersResponseTransfer $transfer, string $resource): SevensendersResponseTransfer;
}
