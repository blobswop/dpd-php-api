<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles address data. */
class AddressWithType extends AddressWithBusinessUnit
{
    const TYPE_PRV = 'PRV';
    const TYPE_COM = 'COM';

    /**
     * Address Type. Allowed values are:
     * PRV: Private customer
     * COM: Commercial customer
     * @var string
     */
    protected string $addressType;

    /**
     * @return string|null
     */
    public function getAddressType(): ?string
    {
        return $this->addressType ?? null;
    }

    /**
     * @param string $addressType
     * @return static
     * @throws WrongArgumentException
     */
    public function setAddressType(string $addressType): static
    {
        if (!in_array($addressType, $typeList = $this->getAllowedAddressTypeList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed type list %s, entered: %s',
                    implode(', ', $typeList),
                    $addressType
                )
            );
        }

        $this->addressType = $addressType;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddressTypePrivate(): static
    {
        $this->addressType = self::TYPE_PRV;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddressTypeCommercial(): static
    {
        $this->addressType = self::TYPE_COM;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllowedAddressTypeList(): array
    {
        return [
            self::TYPE_PRV,
            self::TYPE_COM
        ];
    }
}