<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Api\Adapter;

use Generated\Shared\Transfer\SevensendersRequestTransfer;

interface AdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $transfer
     * @param string $resource
     *
     * @return string
     */
    public function sendRequest(SevensendersRequestTransfer $transfer, string $resource);
}
