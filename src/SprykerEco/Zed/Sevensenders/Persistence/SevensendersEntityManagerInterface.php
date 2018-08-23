<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
