<?php

namespace Dpd\Business;

/** Contains the output data, e.g. parcel labels. */
class OutputType
{
    /**
     * The type of the output data.
     * @var string
     */
    protected string $format;

    /**
     * The output data
     * @var string
     */
    protected string $content;

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format ?? null;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content ?? null;
    }
}