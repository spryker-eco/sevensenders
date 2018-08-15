<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Handler\Auth;

interface AuthHandlerInterface
{
    /**
     * @return string
     */
    public function handle(): string;
}
