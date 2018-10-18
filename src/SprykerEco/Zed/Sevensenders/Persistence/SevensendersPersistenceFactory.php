<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Sevensenders\Persistence;

use Orm\Zed\Sevensenders\Persistence\SpySevensendersResponseQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerEco\Zed\Sevensenders\SevensendersConfig getConfig()
 */
class SevensendersPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Sevensenders\Persistence\SpySevensendersResponseQuery
     */
    public function createSpySevensendersResponseQuery(): SpySevensendersResponseQuery
    {
        return SpySevensendersResponseQuery::create();
    }
}
