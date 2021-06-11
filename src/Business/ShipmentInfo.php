<?php

namespace Dpd\Business;

/** Contains general shipment information (e.g. service code). */
class ShipmentInfo extends StatusInfo
{
    /**
     * Receiver of parcel.
     * @var ContentItem
     */
    protected ContentItem $receiver;

    /**
     * Information about estimated delivery time of parcel (DPD Predict).
     * @var ContentItem
     */
    protected ContentItem $predictInformation;

    /**
     * Name of DPD product of the parcel (e.g. DPD Classic).
     * @var ContentItem
     */
    protected ContentItem $serviceDescription;

    /**
     * Additional services for DPD product.
     * @var ContentItem
     */
    protected ContentItem $additionalServiceElements;

    /**
     * Properties.
     * @var TrackingProperty[]
     */
    protected array $trackingProperty;

    /**
     * @return ContentItem|null
     */
    public function getReceiver(): ?ContentItem
    {
        return $this->receiver ?? null;
    }

    /**
     * @return ContentItem|null
     */
    public function getPredictInformation(): ?ContentItem
    {
        return $this->predictInformation ?? null;
    }

    /**
     * @return ContentItem|null
     */
    public function getServiceDescription(): ?ContentItem
    {
        return $this->serviceDescription ?? null;
    }

    /**
     * @return ContentItem|null
     */
    public function getAdditionalServiceElements(): ?ContentItem
    {
        return $this->additionalServiceElements ?? null;
    }

    /**
     * @return TrackingProperty[]
     */
    public function getTrackingProperty(): array
    {
        return $this->trackingProperty ?? [];
    }
}