<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

class GetTrackingData
{
    const PATTERN_PARCEL_LABEL_NUMBER = '/^.{14}$/u';

    /**
     * Parcel label number
     * @var string
     */
    protected string $parcelLabelNumber;

    /**
     * @param string $parcelLabelNumber
     * @throws WrongArgumentException
     */
    public function __construct(string $parcelLabelNumber)
    {
        $this->setParcelLabelNumber($parcelLabelNumber);
    }

    /**
     * @param string $parcelLabelNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setParcelLabelNumber(string $parcelLabelNumber): static
    {
        if (!preg_match(self::PATTERN_PARCEL_LABEL_NUMBER, $parcelLabelNumber)) {
            throw new WrongArgumentException(
                sprintf('parcelLabelNumber pattern mismatch, entered %s', $parcelLabelNumber)
            );
        }

        $this->parcelLabelNumber = $parcelLabelNumber;
        return $this;
    }
}