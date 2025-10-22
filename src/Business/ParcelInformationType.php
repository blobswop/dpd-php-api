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
     * @var array
     */
    protected array $output = [];

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
     * @return array
     */
    public function getOutput(): array
    {
        return $this->output;
    }

    /**
     * @var OutputType
     * @return ParcelInformationType
     */
    public function addOutput(OutputType $o): self
    {
        $this->output[] = $o;
        return $this;
    }
}