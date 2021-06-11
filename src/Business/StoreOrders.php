<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Stores up to 30 shipments and creates corresponding shipment documents. */
class StoreOrders
{
    const MAX_ORDER_COUNT = 30;

    /**
     * The Options which should be used for parcel printing
     * @var PrintOptions
     */
    protected PrintOptions $printOptions;

    /**
     * Contains the whole data for the shipments.
     * @var ShipmentServiceData[]
     */
    protected array $order;

    /**
     * @return PrintOptions|null
     */
    public function getPrintOptions(): ?PrintOptions
    {
        return $this->printOptions ?? null;
    }

    /**
     * @param PrintOptions $printOptions
     * @return static
     */
    public function setPrintOptions(PrintOptions $printOptions): static
    {
        $this->printOptions = $printOptions;
        return $this;
    }

    /**
     * @return ShipmentServiceData[]|null
     */
    public function getOrder(): ?array
    {
        return $this->order ?? null;
    }

    /**
     * @param ShipmentServiceData[] $order
     * @return static
     * @throws WrongArgumentException
     */
    public function setOrder(array $order): static
    {
        if (count($order) > self::MAX_ORDER_COUNT) {
            throw new WrongArgumentException(
                sprintf('max count order is %d', self::MAX_ORDER_COUNT)
            );
        }

        $this->order = $order;
        return $this;
    }

    /**
     * @param ShipmentServiceData $order
     * @return static
     * @throws WrongArgumentException
     */
    public function addOrder(ShipmentServiceData $order): static
    {
        if (count($this->order ?? []) >= self::MAX_ORDER_COUNT) {
            throw new WrongArgumentException(
                sprintf('max count order is %d', self::MAX_ORDER_COUNT)
            );
        }

        $this->order[] = $order;
        return $this;
    }
}