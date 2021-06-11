<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles shipment service data. */
class ShipmentServiceData
{
    const MAX_PARCELS_COUNT = 100;

    /**
     * Contains general data for a shipment.
     * @var GeneralShipmentData
     */
    protected GeneralShipmentData $generalShipmentData;

    /**
     * Contains information for the parcels.
     * @var Parcel[]
     */
    protected array $parcels;

    /**
     * Contains special data for a shipment.
     * @var ProductAndServiceData
     */
    protected ProductAndServiceData $productAndServiceData;

    /**
     * @return GeneralShipmentData|null
     */
    public function getGeneralShipmentData(): ?GeneralShipmentData
    {
        return $this->generalShipmentData ?? null;
    }

    /**
     * @param GeneralShipmentData $generalShipmentData
     * @return static
     */
    public function setGeneralShipmentData(GeneralShipmentData $generalShipmentData): static
    {
        $this->generalShipmentData = $generalShipmentData;
        return $this;
    }

    /**
     * @return Parcel[]|null
     */
    public function getParcels(): ?array
    {
        return $this->parcels ?? null;
    }

    /**
     * @param Parcel[] $parcels
     * @return static
     * @throws WrongArgumentException
     */
    public function setParcels(array $parcels): static
    {
        if (count($parcels) > self::MAX_PARCELS_COUNT) {
            throw new WrongArgumentException(
                sprintf('max count parcels is %d', self::MAX_PARCELS_COUNT)
            );
        }

        $this->parcels = $parcels;
        return $this;
    }

    /**
     * @param Parcel $parcel
     * @return static
     * @throws WrongArgumentException
     */
    public function addParcel(Parcel $parcel): static
    {
        if (count($this->parcels ?? []) >= self::MAX_PARCELS_COUNT) {
            throw new WrongArgumentException(
                sprintf('max count parcels is %d', self::MAX_PARCELS_COUNT)
            );
        }

        $this->parcels[] = $parcel;
        return $this;
    }

    /**
     * @return ProductAndServiceData|null
     */
    public function getProductAndServiceData(): ?ProductAndServiceData
    {
        return $this->productAndServiceData ?? null;
    }

    /**
     * @param ProductAndServiceData $productAndServiceData
     * @return static
     */
    public function setProductAndServiceData(ProductAndServiceData $productAndServiceData): static
    {
        $this->productAndServiceData = $productAndServiceData;
        return $this;
    }
}