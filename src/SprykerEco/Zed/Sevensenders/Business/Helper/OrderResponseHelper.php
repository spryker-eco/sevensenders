<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Helper;

use SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface;

class OrderResponseHelper implements ResponseHelperInterface
{
    protected const STATUS_CREATED = 201;
    protected const STATUS_UPDATED = 200;

    /**
     * @var \SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface $sevensendersRepository
     */
    protected $sevensendersRepository;

    /**
     * @param \SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface $sevensendersRepository
     */
    public function __construct(SevensendersRepositoryInterface $sevensendersRepository)
    {
        $this->sevensendersRepository = $sevensendersRepository;
    }

    /**
     * @param int $isSalesOrder
     *
     * @return bool
     */
    public function isLastResponseSuccessful(int $isSalesOrder): bool
    {
        return in_array($this->sevensendersRepository->getResponseByOrderId($isSalesOrder)->getStatus(), [
            static::STATUS_CREATED,
            static::STATUS_UPDATED,
        ]);
    }
}
