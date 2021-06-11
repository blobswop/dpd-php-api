<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles notification data. */
class Notification
{
    const CHANNEL_EMAIL = 1;
    const CHANNEL_TELEPHONE = 2;
    const CHANNEL_SMS = 3;

    const MAX_LENGTH_VALUE = 50;

    const PATTERN_LANGUAGE = '/^[A-Z]{2}$/u';

    /**
     * Declares channel of notification. Possible values are:
     * 1 = Email
     * 2 = Telephone
     * 3 = SMS
     * @var int
     */
    protected int $channel;

    /**
     * Value for the chosen channel, i.e. the phone number or the e-mail address.
     *
     * The data format for the proactive message types SMS, phone and FAX is as follows:
     * +international country number#phone number
     *
     * Examples:
     * +49#1725673423
     * +49#01725673423
     * @var string
     */
    protected string $value;

    /**
     * Language of the notification in ISO 3166-1 alpha-2 format (e.g. 'DE').
     * @var string
     */
    protected string $language;

    /**
     * @return int|null
     */
    public function getChannel(): ?int
    {
        return $this->channel ?? null;
    }

    /**
     * @param int $channel
     * @return static
     * @throws WrongArgumentException
     */
    public function setChannel(int $channel): static
    {
        if (!in_array($channel, $allowedList = $this->getAllowedChannelList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed channel is %s, entered %s',
                    implode(', ', $allowedList),
                    $channel
                )
            );
        }

        $this->channel = $channel;
        return $this;
    }

    /**
     * @return static
     */
    public function setChannelEmail(): static
    {
        $this->channel = self::CHANNEL_EMAIL;
        return $this;
    }

    /**
     * @return static
     */
    public function setChannelTelephone(): static
    {
        $this->channel = self::CHANNEL_TELEPHONE;
        return $this;
    }

    /**
     * @return static
     */
    public function setChannelSms(): static
    {
        $this->channel = self::CHANNEL_SMS;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value ?? null;
    }

    /**
     * @param string $value
     * @return static
     * @throws WrongArgumentException
     */
    public function setValue(string $value): static
    {
        if (mb_strlen($value) > self::MAX_LENGTH_VALUE) {
            throw new WrongArgumentException(
                sprintf('max length value is %d', self::MAX_LENGTH_VALUE)
            );
        }

        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language ?? null;
    }

    /**
     * @param string $language
     * @return static
     * @throws WrongArgumentException
     */
    public function setLanguage(string $language): static
    {
        if (!preg_match(self::PATTERN_LANGUAGE, $language)) {
            throw new WrongArgumentException(
                sprintf('language pattern mismatch, entered %s', $language)
            );
        }

        $this->language = $language;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getAllowedChannelList(): array
    {
        return [
            self::CHANNEL_EMAIL,
            self::CHANNEL_TELEPHONE,
            self::CHANNEL_SMS
        ];
    }
}