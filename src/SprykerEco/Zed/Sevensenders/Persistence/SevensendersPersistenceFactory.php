<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
