<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles proactive notification data. */
class ProactiveNotification extends Notification
{
    const CHANNEL_FAX = 6;
    const CHANNEL_POSTCARD = 7;

    const RULE_PICK_UP = 1;
    const RULE_NON_DELIVERY = 2;
    const RULE_DELIVERY = 4;
    const RULE_INBOUND = 8;
    const RULE_OUT_OF_DELIVERY = 16;

    const MAX_RULE = 31;

    /**
     * Specifies for which events a notification is to be issued.
     * Each event has a certain integer value. By
     * adding the different values, it is possible to build
     * combinations of events, e.g. notification for pick-up and delivery is 5.
     * The different values are: 1 = Pick-up,
     * 2 = Non-delivery,
     * 4 = Delivery,
     * 8 = Inbound,
     * 16 = Out for delivery.
     * So maximum value can be 31.
     * @var int
     */
    protected int $rule;

    /**
     * @return static
     */
    public function setChannelFax(): static
    {
        $this->channel = self::CHANNEL_FAX;
        return $this;
    }

    /**
     * @return static
     */
    public function setChannelPostcard(): static
    {
        $this->channel = self::CHANNEL_POSTCARD;
        return $this;
    }

    /**
     * @return int
     */
    public function getRule(): int
    {
        return $this->rule ?? 0;
    }

    /**
     * @param int $rule
     * @return static
     * @throws WrongArgumentException
     */
    public function setRule(int $rule): static
    {
        if ($rule > self::MAX_RULE) {
            throw new WrongArgumentException(
                sprintf('max rule value is %d', self::MAX_RULE)
            );
        }

        $this->rule = $rule;
        return $this;
    }

    /**
     * @return static
     */
    public function addRulePickUp(): static
    {
        $this->rule = $this->getRule() + self::RULE_PICK_UP;
        return $this;
    }

    /**
     * @return static
     */
    public function addRuleNonDelivery(): static
    {
        $this->rule = $this->getRule() + self::RULE_NON_DELIVERY;
        return $this;
    }

    /**
     * @return static
     */
    public function addRuleDelivery(): static
    {
        $this->rule = $this->getRule() + self::RULE_DELIVERY;
        return $this;
    }

    /**
     * @return static
     */
    public function addRuleInbound(): static
    {
        $this->rule = $this->getRule() + self::RULE_INBOUND;
        return $this;
    }

    /**
     * @return static
     */
    public function addRuleOutForDelivery(): static
    {
        $this->rule = $this->getRule() + self::RULE_OUT_OF_DELIVERY;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedChannelList(): array
    {
        return
            array_merge(
                parent::getAllowedChannelList(),
                [
                    self::CHANNEL_FAX,
                    self::CHANNEL_POSTCARD
                ]
            );
    }
}