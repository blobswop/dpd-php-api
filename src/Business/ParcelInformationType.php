<?php

namespace Dpd\Business;

/** Bundles parcel information type data. */
class ParcelInformationType
{
    /**
     * The parcel label number of the corresponding parcel.
     * @var string
     */
    protected string $parcelLabelNumber;

    /**
     * The DPD reference for this parcel.
     * @var string
     */
    protected string $dpdReference;

    /**
     * The content for the parcel.
     * @var OutputType
     */
    protected OutputType $output;

    /**
     * @return string|null
     */
    public function getParcelLabelNumber(): ?string
    {
        return $this->parcelLabelNumber ?? null;
    }

    /**
     * @return string|null
     */
    public function getDpdReference(): ?string
    {
        return $this->dpdReference ?? null;
    }

    /**
     * @return OutputType|null
     */
    public function getOutput(): ?OutputType
    {
        return $this->output ?? null;
    }
}