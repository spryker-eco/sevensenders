<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Generated\Shared\Transfer\SpySevensendersResponseEntityTransfer;
use Orm\Zed\Sevensenders\Persistence\SpySevensendersResponse;

interface SevensendersEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpySevensendersResponseEntityTransfer $transfer
     * @param string $resource
     *
     * @return \Orm\Zed\Sevensenders\Persistence\SpySevensendersResponse
     */
    public function createSevensendersResponse(SpySevensendersResponseEntityTransfer $transfer, string $resource): SpySevensendersResponse;
}
