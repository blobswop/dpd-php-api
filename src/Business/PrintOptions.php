<?php

namespace Dpd\Business;

/** Options how to return the parcel labels */
class PrintOptions
{
    /**
     * The formats in which the parcel labels should be returned.
     * If more than one format is set, the option splitByParcel is set implicitly.
     * @var PrintOption[]
     */
    protected array $printOption;

    /**
     * Determines whether a complete parcel label sheet will be created or a single one for each parcel.
     * If format is BARCODE_IMAGE then this is set implicitly.
     * @var bool
     */
    protected bool $splitByParcel;

    /**
     * @return PrintOption[]|null
     */
    public function getPrintOption(): ?array
    {
        return $this->printOption ?? null;
    }

    /**
     * @param PrintOption $printOption
     * @return static
     */
    public function addPrintOption(PrintOption $printOption): static
    {
        $this->printOption[] = $printOption;
        return $this;
    }

    /**
     * @param PrintOption[] $printOption
     * @return static
     */
    public function setPrintOption(array $printOption): static
    {
        $this->printOption = $printOption;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isSplitByParcel(): ?bool
    {
        return $this->splitByParcel ?? null;
    }

    /**
     * @param bool $splitByParcel
     * @return static
     */
    public function setSplitByParcel(bool $splitByParcel): static
    {
        $this->splitByParcel = $splitByParcel;
        return $this;
    }
}