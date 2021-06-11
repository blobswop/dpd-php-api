<?php

namespace Dpd\Business;

class TrackingProperty
{
    /**
     * Property key.
     * Possible keys:
     * - showFollowMyParcelLink (value: true)
     * @var string
     */
    protected string $key;

    /**
     * Property value
     * @var string
     */
    protected string $value;

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key ?? null;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value ?? null;
    }
}