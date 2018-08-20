<?php

namespace SprykerEco\Zed\Sevensenders\Business\Helper;

use Generated\Shared\Transfer\SevensendersTokenTransfer;

class TokenHelper implements TokenHelperInterface
{
    /**
     * @param \Generated\Shared\Transfer\SevensendersTokenTransfer $tokenTransfer
     *
     * @return bool
     */
    public function isTokenValid(SevensendersTokenTransfer $tokenTransfer): bool
    {
        $currentUnixTimestamp = date('U');
        $validUnixTimestamp = $tokenTransfer->getUnixTimestamp() + 3600;

        return $currentUnixTimestamp > $validUnixTimestamp;
    }
}
