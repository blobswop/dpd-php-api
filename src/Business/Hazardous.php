<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles hazardous materials data. */
class Hazardous
{
    const PACKING_CODE_0A = '0A'; // Thin sheet packing
    const PACKING_CODE_0A1 = '0A1';// Thin sheet packing with non removable head
    const PACKING_CODE_0A2 = '0A2'; // Thin sheet packing with removable head
    const PACKING_CODE_1A = '1A'; // Steel barrel
    const PACKING_CODE_1A1 = '1A1'; // Steel barrel with non removable head
    const PACKING_CODE_1A2 = '1A2'; // Steel barrel with removable head
    const PACKING_CODE_1B = '1B'; // Aluminium barrel
    const PACKING_CODE_1B1 = '1B1'; // Aluminium barrel with non removable head
    const PACKING_CODE_1B2 = '1B2'; // Aluminium barrel with removable head
    const PACKING_CODE_1H = '1H'; // Plastics barrel
    const PACKING_CODE_1H1 = '1H1'; // Plastics barrel with non removable head
    const PACKING_CODE_1H2 = '1H2'; // Plastics barrel with removable head
    const PACKING_CODE_3A = '3A'; // Steel canister
    const PACKING_CODE_3A1 = '3A1'; // Steel canister with non removable head
    const PACKING_CODE_3A2 = '3A2'; // Steel canister with removable head
    const PACKING_CODE_3B = '3B'; // Aluminium canister
    const PACKING_CODE_3B1 = '3B1'; // Aluminium canister with non removable head
    const PACKING_CODE_3B2 = '3B2'; // Aluminium canister with removable head
    const PACKING_CODE_3H = '3H'; // Plastics canister
    const PACKING_CODE_3H1 = '3H1'; // Plastics canister with non removable head
    const PACKING_CODE_3H2 = '3H2'; // Plastics canister with removable head
    const PACKING_CODE_4A = '4A'; // Steel crates
    const PACKING_CODE_4B = '4B'; // Aluminium crate
    const PACKING_CODE_4D = '4D'; // Plywood crate
    const PACKING_CODE_4G = '4G'; // Cardboard crate
    const PACKING_CODE_4H = '4H'; // Plastics crate
    const PACKING_CODE_4H1 = '4H1'; // Plastics crate plastics expanded
    const PACKING_CODE_4H2 = '4H2'; // Plastics crate plastics solid
    const PACKING_CODE_5H = '5H'; // Plastics bags
    const PACKING_CODE_5M = '5M'; // Paper bags
    const PACKING_CODE_6H = '6H'; // Combination packings

    const TUNNEL_RESTRICTION_CODE_A = 'A';
    const TUNNEL_RESTRICTION_CODE_B = 'B';
    const TUNNEL_RESTRICTION_CODE_C = 'C';
    const TUNNEL_RESTRICTION_CODE_D = 'D';
    const TUNNEL_RESTRICTION_CODE_E = 'E';

    const MAX_LENGTH_IDENTIFICATION_CLASS = 6;
    const MAX_LENGTH_CLASSIFICATION_CODE = 5;
    const MAX_LENGTH_PACKING_GROUP = 5;
    const MAX_LENGTH_DESCRIPTION = 160;
    const MAX_LENGTH_SUBSIDIARY_RISK = 10;
    const MAX_LENGTH_NET_OTHERWISE_SPECIFIED = 150;

    const MAX_FACTOR = 999;

    const PATTERN_IDENTIFICATION_UN_NUMBER = '/^\d{4}$/u';
    const PATTERN_HAZARDOUS_WEIGHT = '/^\d{1,4}\.\d{1,2}$/u';
    const PATTERN_NET_WEIGHT = '/^\d{1,4}\.\d{1,2}$/u';

    /**
     * Defines UN number of hazardous substance. UN numbers range between 0004 and 9004.
     * @var string
     */
    protected string $identificationUnNo;

    /**
     * Declares class of hazardous substance. Possible values range from 1 to 9.
     * Subclasses are specified as position after decimal point
     * (e.g. class 1 is "explosives", class 1.6 is "extremely insensitive explosives").
     * @var string
     */
    protected string $identificationClass;

    /**
     * Declares classification code of hazardous substance.
     * @var string
     */
    protected string $classificationCode;

    /**
     * Declares packing group of hazardous substance. Valid values are "I", "II" and "III".
     * @var string
     */
    protected string $packingGroup;

    /**
     * Declares packing code.
     * Possible values are:
     * 0A = Thin sheet packing,
     * 0A1 = Thin sheet packing with non removable head,
     * 0A2 = Thin sheet packing with removable head,
     * 1A = Steel barrel,
     * 1A1 = Steel barrel with non removable head,
     * 1A2 = Steel barrel with removable head,
     * 1B = Aluminium barrel,
     * 1B1 = Aluminium barrel with non removable head,
     * 1B2 = Aluminium barrel with removable head,
     * 1H = Plastics barrel,
     * 1H1 = Plastics barrel with non removable head,
     * 1H2 = Plastics barrel with removable head,
     * 3A = Steel canister,
     * 3A1 = Steel canister with non removable head,
     * 3A2 = Steel canister with removable head,
     * 3B = Aluminium canister,
     * 3B1 = Aluminium canister with non removable head,
     * 3B2 = Aluminium canister with removable head,
     * 3H = Plastics canister,
     * 3H1 = Plastics canister with non removable head,
     * 3H2 = Plastics canister with removable head,
     * 4A = Steel crates,
     * 4B = Aluminium crate,
     * 4D = Plywood crate,
     * 4G = Cardboard crate,
     * 4H = Plastics crate,
     * 4H1 = Plastics crate plastics expanded,
     * 4H2 = Plastics crate plastics solid,
     * 5H = Plastics bags,
     * 5M = Paper bags,
     * 6H = Combination packings.
     * @var string
     */
    protected string $packingCode;

    /**
     * Description of hazardous substance (redundant).
     * @var string
     */
    protected string $description;

    /**
     * Subsidiary risk of hazardous substance (redundant).
     * @var string
     */
    protected string $subsidiaryRisk;

    /**
     * Tunnel restriction code of hazardous substance.
     * Possible values are "A", "B", "C", "D" or "E".
     * @var string
     */
    protected string $tunnelRestrictionCode;

    /**
     * Weight of hazardous substance with up to 4 pre- decimal point positions and 2 decimal digits with separator.
     * @var float
     */
    protected float $hazardousWeight;

    /**
     * Net weight of hazardous substance with up to 4 pre-decimal point positions and 2 decimal point positions.
     * @var float
     */
    protected float $netWeight;

    /**
     * Factor of hazardous substance (redundant), 999 means unlimited.
     * @var int
     */
    protected int $factor;

    /**
     * A not otherwise specified text which is mandatory for some substances.
     * @var string
     */
    protected string $notOtherwiseSpecified;

    /**
     * @return string|null
     */
    public function getIdentificationUnNo(): ?string
    {
        return $this->identificationUnNo ?? null;
    }

    /**
     * @param string $identificationUnNo
     * @return static
     * @throws WrongArgumentException
     */
    public function setIdentificationUnNo(string $identificationUnNo): static
    {
        if (!preg_match(self::PATTERN_IDENTIFICATION_UN_NUMBER, $identificationUnNo)) {
            throw new WrongArgumentException(
                sprintf(
                    'identificationUnNo should be UN numbers range between 0004 and 900, entered %s',
                    $identificationUnNo
                )
            );
        }

        $this->identificationUnNo = $identificationUnNo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdentificationClass(): ?string
    {
        return $this->identificationClass ?? null;
    }

    /**
     * @param string $identificationClass
     * @return static
     * @throws WrongArgumentException
     */
    public function setIdentificationClass(string $identificationClass): static
    {
        if (mb_strlen($identificationClass) > self::MAX_LENGTH_IDENTIFICATION_CLASS) {
            throw new WrongArgumentException(
                sprintf('max length identificationClass is %d', self::MAX_LENGTH_IDENTIFICATION_CLASS)
            );
        }

        $this->identificationClass = $identificationClass;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClassificationCode(): ?string
    {
        return $this->classificationCode ?? null;
    }

    /**
     * @param string $classificationCode
     * @return static
     * @throws WrongArgumentException
     */
    public function setClassificationCode(string $classificationCode): static
    {
        if (mb_strlen($classificationCode) > self::MAX_LENGTH_CLASSIFICATION_CODE) {
            throw new WrongArgumentException(
                sprintf('max length classificationCode is %d', self::MAX_LENGTH_CLASSIFICATION_CODE)
            );
        }

        $this->classificationCode = $classificationCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPackingGroup(): ?string
    {
        return $this->packingGroup ?? null;
    }

    /**
     * @param string $packingGroup
     * @return static
     * @throws WrongArgumentException
     */
    public function setPackingGroup(string $packingGroup): static
    {
        if (mb_strlen($packingGroup) > self::MAX_LENGTH_PACKING_GROUP) {
            throw new WrongArgumentException(
                sprintf('max length packingGroup is %d', self::MAX_LENGTH_PACKING_GROUP)
            );
        }

        $this->packingGroup = $packingGroup;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPackingCode(): ?string
    {
        return $this->packingCode ?? null;
    }

    /**
     * @param string $packingCode
     * @return static
     * @throws WrongArgumentException
     */
    public function setPackingCode(string $packingCode): static
    {
        if (!in_array($packingCode, $allowedList = $this->getAllowedPackingCodeList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed packingCode is %s, entered %s',
                    implode(', ', $allowedList),
                    $packingCode
                )
            );
        }

        $this->packingCode = $packingCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    /**
     * @param string $description
     * @return static
     * @throws WrongArgumentException
     */
    public function setDescription(string $description): static
    {
        if (mb_strlen($description) > self::MAX_LENGTH_DESCRIPTION) {
            throw new WrongArgumentException(
                sprintf('max length description is %d', self::MAX_LENGTH_DESCRIPTION)
            );
        }

        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubsidiaryRisk(): ?string
    {
        return $this->subsidiaryRisk ?? null;
    }

    /**
     * @param string $subsidiaryRisk
     * @return static
     * @throws WrongArgumentException
     */
    public function setSubsidiaryRisk(string $subsidiaryRisk): static
    {
        if (mb_strlen($subsidiaryRisk) > self::MAX_LENGTH_SUBSIDIARY_RISK) {
            throw new WrongArgumentException(
                sprintf('max length subsidiaryRisk is %d', self::MAX_LENGTH_SUBSIDIARY_RISK)
            );
        }

        $this->subsidiaryRisk = $subsidiaryRisk;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTunnelRestrictionCode(): ?string
    {
        return $this->tunnelRestrictionCode ?? null;
    }

    /**
     * @param string $tunnelRestrictionCode
     * @return static
     * @throws WrongArgumentException
     */
    public function setTunnelRestrictionCode(string $tunnelRestrictionCode): static
    {
        if (!in_array($tunnelRestrictionCode, $allowedList = $this->getAllowedTunnelRestrictionCodeList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed tunnelRestrictionCode is %s, entered %s',
                    implode(', ', $allowedList),
                    $tunnelRestrictionCode
                )
            );
        }

        $this->tunnelRestrictionCode = $tunnelRestrictionCode;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getHazardousWeight(): ?float
    {
        return $this->hazardousWeight ?? null;
    }

    /**
     * @param float $hazardousWeight
     * @return static
     * @throws WrongArgumentException
     */
    public function setHazardousWeight(float $hazardousWeight): static
    {
        if (!preg_match(self::PATTERN_HAZARDOUS_WEIGHT, (string)$hazardousWeight)) {
            throw new WrongArgumentException(
                sprintf(
                    'hazardousWeight up to 4 pre- decimal point positions '
                    . 'and 2 decimal digits with separator, entered %s',
                    $hazardousWeight
                )
            );
        }

        $this->hazardousWeight = $hazardousWeight;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getNetWeight(): ?float
    {
        return $this->netWeight ?? null;
    }

    /**
     * @param float $netWeight
     * @return static
     * @throws WrongArgumentException
     */
    public function setNetWeight(float $netWeight): static
    {
        if (!preg_match(self::PATTERN_NET_WEIGHT, (string)$netWeight)) {
            throw new WrongArgumentException(
                sprintf(
                    'netWeight up to 4 pre- decimal point positions '
                    . 'and 2 decimal digits with separator, entered %s',
                    $netWeight
                )
            );
        }

        $this->netWeight = $netWeight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFactor(): ?int
    {
        return $this->factor ?? null;
    }

    /**
     * @param int $factor
     * @return static
     * @throws WrongArgumentException
     */
    public function setFactor(int $factor): static
    {
        if ($factor > self::MAX_FACTOR) {
            throw new WrongArgumentException(
                sprintf('max factor value is %d', self::MAX_FACTOR)
            );
        }

        $this->factor = $factor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotOtherwiseSpecified(): ?string
    {
        return $this->notOtherwiseSpecified ?? null;
    }

    /**
     * @param string $notOtherwiseSpecified
     * @return static
     * @throws WrongArgumentException
     */
    public function setNotOtherwiseSpecified(string $notOtherwiseSpecified): static
    {
        if (mb_strlen($notOtherwiseSpecified) > self::MAX_LENGTH_NET_OTHERWISE_SPECIFIED) {
            throw new WrongArgumentException(
                sprintf(
                    'max length notOtherwiseSpecified is %d',
                    self::MAX_LENGTH_NET_OTHERWISE_SPECIFIED
                )
            );
        }

        $this->notOtherwiseSpecified = $notOtherwiseSpecified;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllowedPackingCodeList(): array
    {
        return [
            self::PACKING_CODE_0A,
            self::PACKING_CODE_0A1,
            self::PACKING_CODE_0A2,
            self::PACKING_CODE_1A,
            self::PACKING_CODE_1A1,
            self::PACKING_CODE_1A2,
            self::PACKING_CODE_1B,
            self::PACKING_CODE_1B1,
            self::PACKING_CODE_1B2,
            self::PACKING_CODE_1H,
            self::PACKING_CODE_1H1,
            self::PACKING_CODE_1H2,
            self::PACKING_CODE_3A,
            self::PACKING_CODE_3A1,
            self::PACKING_CODE_3A2,
            self::PACKING_CODE_3B,
            self::PACKING_CODE_3B1,
            self::PACKING_CODE_3B2,
            self::PACKING_CODE_3H,
            self::PACKING_CODE_3H1,
            self::PACKING_CODE_3H2,
            self::PACKING_CODE_4A,
            self::PACKING_CODE_4B,
            self::PACKING_CODE_4D,
            self::PACKING_CODE_4G,
            self::PACKING_CODE_4H,
            self::PACKING_CODE_4H1,
            self::PACKING_CODE_4H2,
            self::PACKING_CODE_5H,
            self::PACKING_CODE_5M,
            self::PACKING_CODE_6H
        ];
    }

    /**
     * @return string[]
     */
    public function getAllowedTunnelRestrictionCodeList(): array
    {
        return [
            self::TUNNEL_RESTRICTION_CODE_A,
            self::TUNNEL_RESTRICTION_CODE_B,
            self::TUNNEL_RESTRICTION_CODE_C,
            self::TUNNEL_RESTRICTION_CODE_D,
            self::TUNNEL_RESTRICTION_CODE_E
        ];
    }
}