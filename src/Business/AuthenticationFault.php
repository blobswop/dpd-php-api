<?php

namespace Dpd\Business;

/** The data structure for authentication errors. */
class AuthenticationFault
{
    /**
     * @var string
     */
    protected string $errorCode;

    /**
     * @var string
     */
    protected string $errorMessage;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     */
    public function __construct(string $errorCode, string $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode ?? null;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage ?? null;
    }
}