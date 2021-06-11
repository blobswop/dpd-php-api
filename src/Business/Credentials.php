<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

class Credentials
{
    const PATTERN_MESSAGE_LANGUAGE = '/^[a-z]{2}_[A-Z]{2}$/u';

    /**
     * The DELIS-Id of the user.
     * @var string
     */
    protected string $delisId;

    /**
     * The password of the user.
     * @var string
     */
    protected string $password;

    /**
     * The language (Java format) for messages.
     * "de_DE" for german messages.
     * "en_US" for english messages.
     * @var string
     */
    protected string $messageLanguage;

    /**
     * @param string $delisId The DELIS-Id of the user.
     * @param string $password The password of the user.
     * @param string $messageLanguage
     * The language (Java format) for messages.
     * "de_DE" for german messages.
     * "en_US" for english messages.
     * @throws WrongArgumentException
     */
    public function __construct(
        string $delisId,
        string $password,
        string $messageLanguage = 'en_US'
    ) {
        $this
            ->setDelisId($delisId)
            ->setPassword($password)
            ->setMessageLanguage($messageLanguage);
    }

    /**
     * @param string $delisId
     * @return static
     */
    public function setDelisId(string $delisId): static
    {
        $this->delisId = $delisId;
        return $this;
    }

    /**
     * @param string $password
     * @return static
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
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
                sprintf('expected in format en_US, get: %s', $messageLanguage)
            );
        }

        $this->messageLanguage = $messageLanguage;
        return $this;
    }
}