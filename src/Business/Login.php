<?php

namespace Dpd\Business;

class Login
{
    /**
     * The user's DELIS-Id.
     * @var string
     */
    protected string $delisId;

    /**
     * The user's customer uid. This is needed for subaccounts, usually this is equal to DELIS-Id
     * @var string
     */
    protected string $customerUid;

    /**
     * The Authtoken, needed for other web service calls.
     * @var string
     */
    protected string $authToken;

    /**
     * The depot, to which the user is assigned.
     * @var string
     */
    protected string $depot;

    /**
     * @return string|null
     */
    public function getDelisId(): ?string
    {
        return $this->delisId ?? null;
    }

    /**
     * @return string|null
     */
    public function getCustomerUid(): ?string
    {
        return $this->customerUid ?? null;
    }

    /**
     * @return string|null
     */
    public function getAuthToken(): ?string
    {
        return $this->authToken ?? null;
    }

    /**
     * @return string|null
     */
    public function getDepot(): ?string
    {
        return $this->depot ?? null;
    }
}