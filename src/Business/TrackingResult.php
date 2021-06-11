<?php


namespace Dpd\Business;

/** Result type for tracking data. */
class TrackingResult
{
    /**
     * Information about the shipment.
     * @var ShipmentInfo
     */
    protected ShipmentInfo $shipmentInfo;

    /**
     * Status information.
     * @var StatusInfo[]
     */
    protected array $statusInfo;

    /**
     * Contact information.
     * @var ContentItem[]
     */
    protected array $contactInfo;

    /**
     * @return ShipmentInfo|null
     */
    public function getShipmentInfo(): ?ShipmentInfo
    {
        return $this->shipmentInfo ?? null;
    }

    /**
     * @return StatusInfo[]|null
     */
    public function getStatusInfo(): ?array
    {
        return $this->statusInfo ?? null;
    }

    /**
     * @return ContentItem[]|null
     */
    public function getContactInfo(): ?array
    {
        return $this->contactInfo ?? null;
    }
}