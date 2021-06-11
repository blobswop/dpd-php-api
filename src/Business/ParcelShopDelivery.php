<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles parcel shop delivery data. */
class ParcelShopDelivery
{
    const MAX_LENGTH_PARCEL_SHOP_PUDO_ID = 20;

    const MAX_PARCEL_SHOP_ID = 99999999999999999;

    /**
     * Parcel shop ID for parcel shop delivery. Can be obtained from parcel shop finder.
     * Mandatory for parcel shop delivery.
     * @var int
     */
    protected int $parcelShopId;

    /**
     * ID of PUDO point. For a parcel shop delivery the parcelShopId is also required.
     * @var string
     */
    protected string $parcelShopPudoId;

    /**
     * Contains data for personal notification for parcel shop consignments.
     * @var Notification
     */
    protected Notification $notification;

    /**
     * @return int|null
     */
    public function getParcelShopId(): ?int
    {
        return $this->parcelShopId ?? null;
    }

    /**
     * @param int $parcelShopId
     * @return static
     * @throws WrongArgumentException
     */
    public function setParcelShopId(int $parcelShopId): static
    {
        if ($parcelShopId > self::MAX_PARCEL_SHOP_ID) {
            throw new WrongArgumentException(
                sprintf('max parcelShopId value is %d', self::MAX_PARCEL_SHOP_ID)
            );
        }

        $this->parcelShopId = $parcelShopId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParcelShopPudoId(): ?string
    {
        return $this->parcelShopPudoId ?? null;
    }

    /**
     * @param string $parcelShopPudoId
     * @return static
     * @throws WrongArgumentException
     */
    public function setParcelShopPudoId(string $parcelShopPudoId): static
    {
        if (mb_strlen($parcelShopPudoId) > self::MAX_LENGTH_PARCEL_SHOP_PUDO_ID) {
            throw new WrongArgumentException(
                sprintf('max length parcelShopPudoId is %d', self::MAX_LENGTH_PARCEL_SHOP_PUDO_ID)
            );
        }

        $this->parcelShopPudoId = $parcelShopPudoId;
        return $this;
    }

    /**
     * @return Notification|null
     */
    public function getNotification(): ?Notification
    {
        return $this->notification ?? null;
    }

    /**
     * @param Notification $notification
     * @return static
     */
    public function setNotification(Notification $notification): static
    {
        $this->notification = $notification;
        return $this;
    }
}