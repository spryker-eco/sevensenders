<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Api\Adapter;

use Generated\Shared\Transfer\SevensendersRequestTransfer;
use Generated\Shared\Transfer\SevensendersResponseTransfer;

interface AdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\SevensendersRequestTransfer $transfer
     * @param string $resource
     *
     * @return \Generated\Shared\Transfer\SevensendersResponseTransfer
     */
    public function send(SevensendersRequestTransfer $transfer, string $resource): SevensendersResponseTransfer;
}
