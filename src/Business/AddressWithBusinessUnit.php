<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles address data. */
class AddressWithBusinessUnit extends Address
{
    const MAX_BUSINESS_UNIT = 999;

    /**
     * Business unit of address owner.
     * @var int
     */
    protected int $businessUnit;

    /**
     * @return int|null
     */
    public function getBusinessUnit(): ?int
    {
        return $this->businessUnit ?? null;
    }

    /**
     * @param int $businessUnit
     * @return static
     * @throws WrongArgumentException
     */
    public function setBusinessUnit(int $businessUnit): static
    {
        if ($businessUnit > self::MAX_BUSINESS_UNIT) {
            throw new WrongArgumentException(
                sprintf('max businessUnit value is %d', self::MAX_BUSINESS_UNIT)
            );
        }

        $this->businessUnit = $businessUnit;
        return $this;
    }
}