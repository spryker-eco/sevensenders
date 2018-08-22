<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Sevensenders\Business\Helper;

use SprykerEco\Zed\Sevensenders\Persistence\SevensendersRepositoryInterface;

class OrderResponseHelper implements ResponseHelperInterface
{
    protected const SUCCESSFUL_STATUSES = [200, 201];

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
        return in_array($this->sevensendersRepository->getResponseByOrderId($isSalesOrder)->getStatus(), static::SUCCESSFUL_STATUSES);
    }
}
