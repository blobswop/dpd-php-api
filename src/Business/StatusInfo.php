<?php

namespace Dpd\Business;

/** Contains all information and scan data for a status. */
class StatusInfo
{
    const STATUS_SHIPMENT = 'SHIPMENT';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_AT_SENDING_DEPOT = 'AT_SENDING_DEPOT';
    const STATUS_ON_THE_ROAD = 'ON_THE_ROAD';
    const STATUS_AT_DELIVERY_DEPOT = 'AT_DELIVERY_DEPOT';
    const STATUS_DELIVERED = 'DELIVERED';

    /**
     * Status
     * @var string
     */
    protected string $status;

    /**
     * Name of status.
     * @var ContentLine
     */
    protected ContentLine $label;

    /**
     * Description of status.
     * @var ContentItem
     */
    protected ContentItem $description;

    /**
     * Indicates if status has been reached.
     * @var bool
     */
    protected bool $statusHasBeenReached;

    /**
     * Indicates if status is current status.
     * @var bool
     */
    protected bool $isCurrentStatus;

    /**
     * Defines if contact information shall be displayed on detail page of the status.
     * @var bool
     */
    protected bool $showContactInfo;

    /**
     * Contains the location of the last scan.
     * @var ContentLine
     */
    protected ContentLine $location;

    /**
     * Contains date and time of the last scan.
     * @var ContentLine
     */
    protected ContentLine $date;

    /**
     * A list of content items which describe events classified as NORMAL.
     * @var ContentItem[]
     */
    protected array $normalItems;

    /**
     * A list of content items which describe events classified as IMPORTANT.
     * @var ContentItem[]
     */
    protected array $importantItems;

    /**
     * A list of content items which describe events classified as ERROR.
     * @var ContentItem[]
     */
    protected array $errorItems;

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status ?? null;
    }

    /**
     * @return bool
     */
    public function isStatusShipment(): bool
    {
        return $this->getStatus() == self::STATUS_SHIPMENT;
    }

    /**
     * @return bool
     */
    public function isStatusAccepted(): bool
    {
        return $this->getStatus() == self::STATUS_ACCEPTED;
    }

    /**
     * @return bool
     */
    public function isStatusAtSendingDepot(): bool
    {
        return $this->getStatus() == self::STATUS_AT_SENDING_DEPOT;
    }

    /**
     * @return bool
     */
    public function isStatusOnTheRoad(): bool
    {
        return $this->getStatus() == self::STATUS_ON_THE_ROAD;
    }

    /**
     * @return bool
     */
    public function isStatusAtDeliveryDepot(): bool
    {
        return $this->getStatus() == self::STATUS_AT_DELIVERY_DEPOT;
    }

    /**
     * @return bool
     */
    public function isStatusDelivered(): bool
    {
        return $this->getStatus() == self::STATUS_DELIVERED;
    }

    /**
     * @return ContentLine|null
     */
    public function getLabel(): ?ContentLine
    {
        return $this->label ?? null;
    }

    /**
     * @return ContentItem|null
     */
    public function getDescription(): ?ContentItem
    {
        return $this->description ?? null;
    }

    /**
     * @return bool|null
     */
    public function isStatusHasBeenReached(): ?bool
    {
        return $this->statusHasBeenReached ?? null;
    }

    /**
     * @return bool|null
     */
    public function isCurrentStatus(): ?bool
    {
        return $this->isCurrentStatus ?? null;
    }

    /**
     * @return bool|null
     */
    public function isShowContactInfo(): ?bool
    {
        return $this->showContactInfo ?? null;
    }

    /**
     * @return ContentLine|null
     */
    public function getLocation(): ?ContentLine
    {
        return $this->location ?? null;
    }

    /**
     * @return ContentLine|null
     */
    public function getDate(): ?ContentLine
    {
        return $this->date ?? null;
    }

    /**
     * @return ContentItem[]|null
     */
    public function getNormalItems(): array
    {
        return $this->normalItems ?? [];
    }

    /**
     * @return ContentItem[]|null
     */
    public function getImportantItems(): array
    {
        return $this->importantItems ?? [];
    }

    /**
     * @return ContentItem[]
     */
    public function getErrorItems(): array
    {
        return $this->errorItems ?? [];
    }
}