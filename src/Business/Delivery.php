<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles delivery data. */
class Delivery
{
    const DELIVERY_DAY_SUNDAY = 0;
    const DELIVERY_DAY_MONDAY = 1;
    const DELIVERY_DAY_TUESDAY = 2;
    const DELIVERY_DAY_WEDNESDAY = 3;
    const DELIVERY_DAY_THURSDAY = 4;
    const DELIVERY_DAY_FRIDAY = 5;
    const DELIVERY_DAY_SATURDAY = 6;

    const MAX_LENGTH_DAY = 20;

    const MAX_DATE_FROM = 99999999;
    const MAX_DATE_TO = 99999999;

    const PATTERN_TIME_FROM = '/^([01]\d|2[0-3])([0-5]\d)$/u';
    const PATTERN_TIME_TO = '/^([01]\d|2[0-3])([0-5]\d)$/u';

    /**
     * Allowed delivery days in the week (0 = Sunday, 1 = Monday etc.).
     * Comma separated list of possible delivery days (e.g. "2,3,4,5").
     * @var string
     */
    protected string $day;

    /**
     * Fixed delivery from date - format YYYYMMDD, e.g. 20080213.
     * @var int
     */
    protected int $dateFrom;

    /**
     * Fixed delivery to date - format YYYYMMDD, e.g. 20080213.
     * @var int
     */
    protected int $dateTo;

    /**
     * Time from which the consignee is available - format HHMM (local time receipient country), e.g. 1400 or 0830.
     * @var string
     */
    protected string $timeFrom;

    /**
     * Time until the consignee is available - format HHMM (local time receipient country), e.g. 1600 or 0930.
     * @var string
     */
    protected string $timeTo;

    /**
     * @return string|null
     */
    public function getDay(): ?string
    {
        return $this->day ?? null;
    }

    /**
     * @param string $day
     * @return static
     * @throws WrongArgumentException
     */
    public function setDay(string $day): static
    {
        if (mb_strlen($day) > self::MAX_LENGTH_DAY) {
            throw new WrongArgumentException(
                sprintf('max length day is %d', self::MAX_LENGTH_DAY)
            );
        }

        $days = array_map('trim', explode(',', $day));
        array_map(function ($dayItem) {
            if (!in_array($dayItem, $allowedList = $this->getAllowedDayList())) {
                throw new WrongArgumentException(
                    sprintf(
                        'allowed day item is %s, entered %s',
                        implode(', ', $allowedList),
                        $dayItem
                    )
                );
            }
        }, $days);

        $this->day = implode(',', $days);
        return $this;
    }

    /**
     * @return static
     */
    public function addDaySunday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_SUNDAY;
        return $this;
    }

    /**
     * @return static
     */
    public function addDayMonday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_MONDAY;
        return $this;
    }

    /**
     * @return static
     */
    public function addDayTuesday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_TUESDAY;
        return $this;
    }

    /**
     * @return static
     */
    public function addDayWednesday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_WEDNESDAY;
        return $this;
    }

    /**
     * @return static
     */
    public function addDayThursday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_THURSDAY;
        return $this;
    }

    /**
     * @return static
     */
    public function addDayFriday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_FRIDAY;
        return $this;
    }

    /**
     * @return static
     */
    public function addDaySaturday(): static
    {
        $this->day = (empty($this->getDay()) ? '' : $this->getDay() . ',') . self::DELIVERY_DAY_SATURDAY;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDateFrom(): ?int
    {
        return $this->dateFrom ?? null;
    }

    /**
     * @param int $dateFrom
     * @return static
     * @throws WrongArgumentException
     */
    public function setDateFrom(int $dateFrom): static
    {
        if ($dateFrom > self::MAX_DATE_FROM) {
            throw new WrongArgumentException(
                sprintf('max dateFrom value is %d', self::MAX_DATE_FROM)
            );
        }

        $this->dateFrom = $dateFrom;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDateTo(): ?int
    {
        return $this->dateTo ?? null;
    }

    /**
     * @param int $dateTo
     * @return static
     * @throws WrongArgumentException
     */
    public function setDateTo(int $dateTo): static
    {
        if ($dateTo > self::MAX_DATE_TO) {
            throw new WrongArgumentException(
                sprintf('max dateTo value is %d', self::MAX_DATE_TO)
            );
        }

        $this->dateTo = $dateTo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeFrom(): ?string
    {
        return $this->timeFrom ?? null;
    }

    /**
     * @param string $timeFrom
     * @return static
     * @throws WrongArgumentException
     */
    public function setTimeFrom(string $timeFrom): static
    {
        if (!preg_match(self::PATTERN_TIME_FROM, $timeFrom)) {
            throw new WrongArgumentException(
                sprintf('timeFrom pattern mismatch, entered %s', $timeFrom)
            );
        }

        $this->timeFrom = $timeFrom;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimeTo(): ?string
    {
        return $this->timeTo ?? null;
    }

    /**
     * @param string $timeTo
     * @return static
     * @throws WrongArgumentException
     */
    public function setTimeTo(string $timeTo): static
    {
        if (!preg_match(self::PATTERN_TIME_TO, $timeTo)) {
            throw new WrongArgumentException(
                sprintf('timeTo pattern mismatch, entered %s', $timeTo)
            );
        }

        $this->timeTo = $timeTo;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getAllowedDayList(): array
    {
        return [
            self::DELIVERY_DAY_SUNDAY,
            self::DELIVERY_DAY_MONDAY,
            self::DELIVERY_DAY_TUESDAY,
            self::DELIVERY_DAY_WEDNESDAY,
            self::DELIVERY_DAY_THURSDAY,
            self::DELIVERY_DAY_FRIDAY,
            self::DELIVERY_DAY_SATURDAY
        ];
    }
}