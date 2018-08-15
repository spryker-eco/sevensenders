<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail\Business\Api\Adapter;

use Generated\Shared\Transfer\SevenSendersRequestTransfer;

interface AdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\SevenSendersRequestTransfer $transfer
     *
     * @return string
     */
    public function sendRequest(SevenSendersRequestTransfer $transfer);
}
