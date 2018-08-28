<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Sevensenders\SevensendersConstants;

class SevensendersConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->get(SevensendersConstants::API_URL);
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->get(SevensendersConstants::API_KEY);
    }
}
