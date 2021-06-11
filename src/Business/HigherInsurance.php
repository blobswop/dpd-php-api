<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

class HigherInsurance
{
    const MAX_AMOUNT = 9999999999;

    const PATTERN_CURRENCY = '/^[A-Z]{3}$/u';

    /**
     * Increased insurance value with 2 decimal point positions without separators.
     * @var int
     */
    protected int $amount;

    /**
     * Currency code for increased insurance in format ISO 4217 alpha 3.
     * @var string
     */
    protected string $currency;

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount ?? null;
    }

    /**
     * @param int $amount
     * @return HigherInsurance
     * @throws WrongArgumentException
     */
    public function setAmount(int $amount): HigherInsurance
    {
        if ($amount > self::MAX_AMOUNT) {
            throw new WrongArgumentException(
                sprintf('max amount value is %d', self::MAX_AMOUNT)
            );
        }

        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency ?? null;
    }

    /**
     * @param string $currency
     * @return HigherInsurance
     * @throws WrongArgumentException
     */
    public function setCurrency(string $currency): HigherInsurance
    {
        if (!preg_match(self::PATTERN_CURRENCY, $currency)) {
            throw new WrongArgumentException(
                sprintf('currency should be in format ISO 4217 alpha 3, entered %s', $currency)
            );
        }

        $this->currency = $currency;
        return $this;
    }
}