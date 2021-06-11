<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles pickup data */
class Pickup
{
    const EXTRA_PICKUP_WITHOUT_EXPRESS_SERVICE = 1;
    const EXTRA_PICKUP_WITH_EXPRESS_SERVICE = 2;

    const MAX_LENGTH_BOX_ID = 100;
    const MAX_LENGTH_BOX_TAN = 6;

    const MAX_TOUR = 999;
    const MAX_QUANTITY = 99999;

    const PATTERN_DATE = '/^(\d{2}|\4{4})\d{4}$/u';
    const PATTERN_FROM_TIME1 = '/^([01]\d|2[0-3])([0-5]\d)$/u';
    const PATTERN_TO_TIME1 = '/^([01]\d|2[0-3])([0-5]\d)$/u';
    const PATTERN_FROM_TIME2 = '/^([01]\d|2[0-3])([0-5]\d)$/u';
    const PATTERN_TO_TIME2 = '/^([01]\d|2[0-3])([0-5]\d)$/u';

    /**
     * Tour number (between 000 and 999)
     * @var int
     */
    protected int $tour;

    /**
     * Quantity of pickup parcels. Mandatory for consignment.
     * @var int
     */
    protected int $quantity;

    /**
     * Pickup date in consignments and collection requests. The collection day for advice customers.
     * The from date for pickup information. Format is YYYYMMDD.
     * It can also be used as pickup date for collection requests,
     * then format is YYMMDD. Mandatory for consignment.
     * @var int
     */
    protected int $date;

    /**
     * From time 1 for consignments and pickup information. Format is HHMM.
     * @var string
     */
    protected string $fromTime1;

    /**
     * Until time 1 for consignments and pickup information. Format is HHMM.
     * @var string
     */
    protected string $toTome1;

    /**
     * From time 2 for consignments and pickup information. Format is HHMM.
     * @var string
     */
    protected string $fromTime2;

    /**
     * Until time 2 for consignments and pickup information. Format is HHMM.
     * @var string
     */
    protected string $toTome2;

    /**
     * Detemines whether an extra pickup tour is created for this shipment with express service.
     * Possible values are:
     * 1: Extra pickup without express service,
     * 2: Extra pickup with express service.
     * @var int
     */
    protected int $extraPickup;

    /**
     * The ID of the parcel box.
     * @var string
     */
    protected string $boxId;

    /**
     * The TAN of the parcel box for this order.
     * @var string
     */
    protected string $boxTan;

    /**
     * Contains pickup address information for consignments and collection requests.
     * Mandatory for consignment.
     * @var Address
     */
    protected Address $address;

    /**
     * @return int|null
     */
    public function getTour(): ?int
    {
        return $this->tour ?? null;
    }

    /**
     * @param int $tour
     * @return static
     * @throws WrongArgumentException
     */
    public function setTour(int $tour): static
    {
        if ($tour > self::MAX_TOUR) {
            throw new WrongArgumentException(
                sprintf('max tour value is %d', self::MAX_TOUR)
            );
        }

        $this->tour = $tour;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity ?? null;
    }

    /**
     * @param int $quantity
     * @return static
     * @throws WrongArgumentException
     */
    public function setQuantity(int $quantity): static
    {
        if ($quantity > self::MAX_QUANTITY) {
            throw new WrongArgumentException(
                sprintf('max quantity value is %d', self::MAX_QUANTITY)
            );
        }

        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDate(): ?int
    {
        return $this->date ?? null;
    }

    /**
     * @param int $date
     * @return static
     * @throws WrongArgumentException
     */
    public function setDate(int $date): static
    {
        if (!preg_match(self::PATTERN_DATE, (string)$date)) {
            throw new WrongArgumentException(
                sprintf('date pattern mismatch, entered %s', $date)
            );
        }

        $this->date = $date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromTime1(): ?string
    {
        return $this->fromTime1 ?? null;
    }

    /**
     * @param string $fromTime1
     * @return static
     * @throws WrongArgumentException
     */
    public function setFromTime1(string $fromTime1): static
    {
        if (!preg_match(self::PATTERN_FROM_TIME1, $fromTime1)) {
            throw new WrongArgumentException(
                sprintf('fromTime1 pattern mismatch, entered %s', $fromTime1)
            );
        }

        $this->fromTime1 = $fromTime1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToTome1(): ?string
    {
        return $this->toTome1 ?? null;
    }

    /**
     * @param string $toTome1
     * @return static
     * @throws WrongArgumentException
     */
    public function setToTome1(string $toTome1): static
    {
        if (!preg_match(self::PATTERN_TO_TIME1, $toTome1)) {
            throw new WrongArgumentException(
                sprintf('toTome1 pattern mismatch, entered %s', $toTome1)
            );
        }

        $this->toTome1 = $toTome1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromTime2(): ?string
    {
        return $this->fromTime2 ?? null;
    }

    /**
     * @param string $fromTime2
     * @return static
     * @throws WrongArgumentException
     */
    public function setFromTime2(string $fromTime2): static
    {
        if (!preg_match(self::PATTERN_FROM_TIME2, $fromTime2)) {
            throw new WrongArgumentException(
                sprintf('fromTime2 pattern mismatch, entered %s', $fromTime2)
            );
        }

        $this->fromTime2 = $fromTime2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToTome2(): ?string
    {
        return $this->toTome2 ?? null;
    }

    /**
     * @param string $toTome2
     * @return static
     */
    public function setToTome2(string $toTome2): static
    {
        if (!preg_match(self::PATTERN_TO_TIME2, $toTome2)) {
            throw new WrongArgumentException(
                sprintf('toTome2 pattern mismatch, entered %s', $toTome2)
            );
        }

        $this->toTome2 = $toTome2;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getExtraPickup(): ?int
    {
        return $this->extraPickup ?? null;
    }

    /**
     * @param int $extraPickup
     * @return static
     * @throws WrongArgumentException
     */
    public function setExtraPickup(int $extraPickup): static
    {
        if (!in_array($extraPickup, $allowedList = $this->getAllowedExtraPickupList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed extraPickup is %s, entered %s',
                    implode(', ', $allowedList),
                    $extraPickup
                )
            );
        }

        $this->extraPickup = $extraPickup;
        return $this;
    }

    /**
     * @return static
     */
    public function setExtraPickupWithoutExpressService(): static
    {
        $this->extraPickup = self::EXTRA_PICKUP_WITHOUT_EXPRESS_SERVICE;
        return $this;
    }

    /**
     * @return static
     */
    public function setExtraPickupWithExpressService(): static
    {
        $this->extraPickup = self::EXTRA_PICKUP_WITH_EXPRESS_SERVICE;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBoxId(): ?string
    {
        return $this->boxId ?? null;
    }

    /**
     * @param string $boxId
     * @return static
     * @throws WrongArgumentException
     */
    public function setBoxId(string $boxId): static
    {
        if (mb_strlen($boxId) > self::MAX_LENGTH_BOX_ID) {
            throw new WrongArgumentException(
                sprintf('max length boxId is %d', self::MAX_LENGTH_BOX_ID)
            );
        }

        $this->boxId = $boxId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBoxTan(): ?string
    {
        return $this->boxTan ?? null;
    }

    /**
     * @param string $boxTan
     * @return static
     * @throws WrongArgumentException
     */
    public function setBoxTan(string $boxTan): static
    {
        if (mb_strlen($boxTan) > self::MAX_LENGTH_BOX_TAN) {
            throw new WrongArgumentException(
                sprintf('max length boxTan is %d', self::MAX_LENGTH_BOX_TAN)
            );
        }

        $this->boxTan = $boxTan;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address ?? null;
    }

    /**
     * @param Address $address
     * @return static
     */
    public function setAddress(Address $address): static
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getAllowedExtraPickupList(): array
    {
        return [
            self::EXTRA_PICKUP_WITHOUT_EXPRESS_SERVICE,
            self::EXTRA_PICKUP_WITH_EXPRESS_SERVICE
        ];
    }
}