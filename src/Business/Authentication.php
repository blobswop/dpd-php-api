<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** The data structure for authentication data. */
class Authentication
{
    const MAX_LENGTH_AUTH_TOKEN = 64;

    const PATTERN_DELIS_ID = '/^.{8,10}$/u';
    const PATTERN_MESSAGE_LANGUAGE = '/^[a-z]{2}_[A-Z]{2}$/u';

    /**
     * The delis user id for authentication.
     * @var string
     */
    protected string $delisId;

    /**
     * The token for authentication. Field authToken of Login, as a result of Method "getAuth" of LoginService.
     * @var string
     */
    protected string $authToken;

    /**
     * The language (Java format) for messages.
     * "de_DE" for german messages.
     * "en_US" for english messages.
     * @var string
     */
    protected string $messageLanguage;

    /**
     * @return string|null
     */
    public function getDelisId(): ?string
    {
        return $this->delisId ?? null;
    }

    /**
     * @param string $delisId
     * @return static
     * @throws WrongArgumentException
     */
    public function setDelisId(string $delisId): static
    {
        if (!preg_match(self::PATTERN_DELIS_ID, $delisId)) {
            throw new WrongArgumentException(
                sprintf('delisId pattern mismatch, entered %s', $delisId)
            );
        }

        $this->delisId = $delisId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthToken(): ?string
    {
        return $this->authToken ?? null;
    }

    /**
     * @param string $authToken
     * @return static
     * @throws WrongArgumentException
     */
    public function setAuthToken(string $authToken): static
    {
        if (mb_strlen($authToken) > self::MAX_LENGTH_AUTH_TOKEN) {
            throw new WrongArgumentException(
                sprintf('max length authToken is %d', self::MAX_LENGTH_AUTH_TOKEN)
            );
        }

        $this->authToken = $authToken;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessageLanguage(): ?string
    {
        return $this->messageLanguage ?? null;
    }

    /**
     * @param string $messageLanguage
     * @return static
     * @throws WrongArgumentException
     */
    public function setMessageLanguage(string $messageLanguage): static
    {
        if (!preg_match(self::PATTERN_MESSAGE_LANGUAGE, $messageLanguage)) {
            throw new WrongArgumentException(
                sprintf('messageLanguage pattern mismatch, entered %s', $messageLanguage)
            );
        }

        $this->messageLanguage = $messageLanguage;
        return $this;
    }
}