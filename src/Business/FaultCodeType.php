<?php

namespace Dpd\Business;

/** Bundles fault code type data. */
class FaultCodeType
{
    protected string $faultCode;

    protected string $message;

    /**
     * @return ?string
     */
    public function getFaultCode(): ?string
    {
        return $this->faultCode ?? null;
    }

    /**
     * @return ?string
     */
    public function getMessage(): ?string
    {
        return $this->message ?? null;
    }
}