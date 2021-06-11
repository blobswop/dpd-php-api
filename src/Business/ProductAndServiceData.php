<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles product and service data for ShipmentService. */
class ProductAndServiceData
{
    const ORDER_TYPE_CONSIGNMENT = 'consignment';
    const ORDER_TYPE_COLLECTION_REQUEST_ORDER = 'collection request order';
    const ORDER_TYPE_PICKUP_INFORMATION = 'pickup information';

    const MAX_PROACTIVE_NOTIFICATION_COUNT = 5;

    /**
     * Defines the shipment type. Possible values are:
     * consignment,
     * collection request order,
     * pickup information.
     * @var string 
     */
    protected string $orderType;

    /**
     * Specifies if saturday delivery is demanded. Only selectable for product "E12".
     * Default value is false
     * @var bool
     */
    protected bool $saturdayDelivery = false;

    /**
     * Specifies if the recipient has to pay the consignment.
     * Default value is false.
     * @var bool
     */
    protected bool $exWorksDelivery = false;

    /**
     * Set to true if an international shipment should use Guarantee,
     * only for products CL and E18 for international parcels.
     * @var bool
     */
    protected bool $guarantee;

    /**
     * Set to true if this consignment contains bulk tyres, only for product CL.
     * @var bool
     */
    protected bool $tyres;

    /**
     * Set to true if the parcel should deliver as product 'DPD Food'.
     * @var bool
     */
    protected bool $food;

    /**
     * Contains information for personal delivery.
     * @var PersonalDelivery
     */
    protected PersonalDelivery $personalDelivery;

    /**
     * Contains information for pickup consignments, pickup address
     * for collection requests or details for pickup information.
     * @var Pickup
     */
    protected Pickup $pickup;

    /**
     * Contains the necessary information, if a parcel shop delivery is intended.
     * @var ParcelShopDelivery
     */
    protected ParcelShopDelivery $parcelShopDelivery;

    /**
     * Contains data for interactive notification for consignments.
     * The notification type "phone" is forbidden here.
     * @var Notification
     */
    protected Notification $predict;

    /**
     * Contains data for personal delivery notification for consignments.
     * @var Notification
     */
    protected Notification $personalDeliveryNotification;

    /**
     * Contains information of proactive notification for consignments.
     * @var ProactiveNotification[]
     */
    protected array $proactiveNotification;

    /**
     * Contains special delivery data for consignments.
     * @var Delivery
     */
    protected Delivery $delivery;

    /**
     * Contains data about invoice recipient if it differs for consignment.
     * @var Address
     */
    protected Address $invoiceAddress;

    /**
     * In some relations a specific service code can be set, which overwrites the feature selection.
     * @var string
     */
    protected string $countrySpecificService;

    /**
     * Contains data for consignments across customs borders.
     * @var International
     */
    protected International $international;

    /**
     * @return string|null
     */
    public function getOrderType(): ?string
    {
        return $this->orderType ?? null;
    }

    /**
     * @param string $orderType
     * @return static
     * @throws WrongArgumentException
     */
    public function setOrderType(string $orderType): static
    {
        if (!in_array($orderType, $allowedList = $this->getAllowedOrderTypeList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed orderType is %s, entered %s',
                    implode(', ', $allowedList),
                    $orderType
                )
            );
        }

        $this->orderType = $orderType;
        return $this;
    }

    /**
     * @return static
     */
    public function setOrderTypeConsignment(): static
    {
        $this->orderType = self::ORDER_TYPE_CONSIGNMENT;
        return $this;
    }

    /**
     * @return static
     */
    public function setOrderTypeCollectRequestOrder(): static
    {
        $this->orderType = self::ORDER_TYPE_COLLECTION_REQUEST_ORDER;
        return $this;
    }

    /**
     * @return static
     */
    public function setOrderTypePickupInformation(): static
    {
        $this->orderType = self::ORDER_TYPE_PICKUP_INFORMATION;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSaturdayDelivery(): bool
    {
        return $this->saturdayDelivery;
    }

    /**
     * @return bool
     */
    public function getSaturdayDelivery(): bool
    {
        return $this->saturdayDelivery;
    }

    /**
     * @param bool $saturdayDelivery
     * @return static
     */
    public function setSaturdayDelivery(bool $saturdayDelivery): static
    {
        $this->saturdayDelivery = $saturdayDelivery;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExWorksDelivery(): bool
    {
        return $this->exWorksDelivery;
    }

    /**
     * @return bool
     */
    public function getExWorksDelivery(): bool
    {
        return $this->exWorksDelivery;
    }

    /**
     * @param bool $exWorksDelivery
     * @return static
     */
    public function setExWorksDelivery(bool $exWorksDelivery): static
    {
        $this->exWorksDelivery = $exWorksDelivery;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isGuarantee(): ?bool
    {
        return $this->guarantee ?? null;
    }

    /**
     * @return bool|null
     */
    public function getGuarantee(): ?bool
    {
        return $this->guarantee ?? null;
    }

    /**
     * @param bool $guarantee
     * @return static
     */
    public function setGuarantee(bool $guarantee): static
    {
        $this->guarantee = $guarantee;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isTyres(): ?bool
    {
        return $this->tyres ?? null;
    }

    /**
     * @return bool|null
     */
    public function getTyres(): ?bool
    {
        return $this->tyres ?? null;
    }

    /**
     * @param bool $tyres
     * @return static
     */
    public function setTyres(bool $tyres): static
    {
        $this->tyres = $tyres;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isFood(): ?bool
    {
        return $this->food ?? null;
    }

    /**
     * @return bool|null
     */
    public function getFood(): ?bool
    {
        return $this->food ?? null;
    }

    /**
     * @param bool $food
     * @return static
     */
    public function setFood(bool $food): static
    {
        $this->food = $food;
        return $this;
    }

    /**
     * @return PersonalDelivery|null
     */
    public function getPersonalDelivery(): ?PersonalDelivery
    {
        return $this->personalDelivery ?? null;
    }

    /**
     * @param PersonalDelivery $personalDelivery
     * @return static
     */
    public function setPersonalDelivery(PersonalDelivery $personalDelivery): static
    {
        $this->personalDelivery = $personalDelivery;
        return $this;
    }

    /**
     * @return Pickup|null
     */
    public function getPickup(): ?Pickup
    {
        return $this->pickup ?? null;
    }

    /**
     * @param Pickup $pickup
     * @return static
     */
    public function setPickup(Pickup $pickup): static
    {
        $this->pickup = $pickup;
        return $this;
    }

    /**
     * @return ParcelShopDelivery|null
     */
    public function getParcelShopDelivery(): ?ParcelShopDelivery
    {
        return $this->parcelShopDelivery ?? null;
    }

    /**
     * @param ParcelShopDelivery $parcelShopDelivery
     * @return static
     */
    public function setParcelShopDelivery(ParcelShopDelivery $parcelShopDelivery): static
    {
        $this->parcelShopDelivery = $parcelShopDelivery;
        return $this;
    }

    /**
     * @return Notification|null
     */
    public function getPredict(): ?Notification
    {
        return $this->predict ?? null;
    }

    /**
     * @param Notification $predict
     * @return static
     */
    public function setPredict(Notification $predict): static
    {
        $this->predict = $predict;
        return $this;
    }

    /**
     * @return Notification|null
     */
    public function getPersonalDeliveryNotification(): ?Notification
    {
        return $this->personalDeliveryNotification ?? null;
    }

    /**
     * @param Notification $personalDeliveryNotification
     * @return static
     */
    public function setPersonalDeliveryNotification(Notification $personalDeliveryNotification): static
    {
        $this->personalDeliveryNotification = $personalDeliveryNotification;
        return $this;
    }

    /**
     * @return ProactiveNotification[]|null
     */
    public function getProactiveNotification(): ?array
    {
        return $this->proactiveNotification ?? null;
    }

    /**
     * @param ProactiveNotification[] $proactiveNotification
     * @return static
     * @throws WrongArgumentException
     */
    public function setProactiveNotification(array $proactiveNotification): static
    {
        if (count($proactiveNotification) > self::MAX_PROACTIVE_NOTIFICATION_COUNT) {
            throw new WrongArgumentException(
                sprintf(
                    'max count proactiveNotification is %d',
                    self::MAX_PROACTIVE_NOTIFICATION_COUNT
                )
            );
        }

        $this->proactiveNotification = $proactiveNotification;
        return $this;
    }

    /**
     * @param ProactiveNotification $proactiveNotification
     * @return static
     * @throws WrongArgumentException
     */
    public function addProactiveNotification(ProactiveNotification $proactiveNotification): static
    {
        if (count($this->proactiveNotification ?? []) > self::MAX_PROACTIVE_NOTIFICATION_COUNT) {
            throw new WrongArgumentException(
                sprintf(
                    'max count proactiveNotification is %d',
                    self::MAX_PROACTIVE_NOTIFICATION_COUNT
                )
            );
        }

        $this->proactiveNotification[] = $proactiveNotification;
        return $this;
    }

    /**
     * @return Delivery|null
     */
    public function getDelivery(): ?Delivery
    {
        return $this->delivery ?? null;
    }

    /**
     * @param Delivery $delivery
     * @return static
     */
    public function setDelivery(Delivery $delivery): static
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getInvoiceAddress(): ?Address
    {
        return $this->invoiceAddress ?? null;
    }

    /**
     * @param Address $invoiceAddress
     * @return static
     */
    public function setInvoiceAddress(Address $invoiceAddress): static
    {
        $this->invoiceAddress = $invoiceAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountrySpecificService(): ?string
    {
        return $this->countrySpecificService ?? null;
    }

    /**
     * @param string $countrySpecificService
     * @return static
     */
    public function setCountrySpecificService(string $countrySpecificService): static
    {
        $this->countrySpecificService = $countrySpecificService;
        return $this;
    }

    /**
     * @return International|null
     */
    public function getInternational(): ?International
    {
        return $this->international ?? null;
    }

    /**
     * @param International $international
     * @return static
     */
    public function setInternational(International $international): static
    {
        $this->international = $international;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedOrderTypeList(): array
    {
        return [
            self::ORDER_TYPE_CONSIGNMENT,
            self::ORDER_TYPE_COLLECTION_REQUEST_ORDER,
            self::ORDER_TYPE_PICKUP_INFORMATION
        ];
    }
}