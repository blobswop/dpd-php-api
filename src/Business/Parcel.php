<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles parcel data. */
class Parcel
{
    const ADD_SERVICE_DELIVERY_INFORMATION = 1;
    const ADD_SERVICE_DOCUMENTS_RETURN = 2;
    const ADD_SERVICE_WRITTEN_PERMISSIONS = 3;
    const ADD_SERVICE_DEPARTMENT_DELIVERY = 4;
    const ADD_SERVICE_ONLINE_PERMISSION = 5;
    const ADD_SERVICE_PARCEL_BOX = 6;
    const ADD_SERVICE_INFORMATION_AT_INDOOR_SCANNING = 7;
    const ADD_SERVICE_LOCKING_OUT_FOR_DELIVERY = 8;

    const FUNCTION_LOCKDZB = 'LOCKDZB'; // Delivery to a third party with notification of delivery
    const FUNCTION_LOCKASG = 'LOCKASG'; // Written permission to deposit goods
    const FUNCTION_LOCKEVM = 'LOCKEVM'; // Delivery with non-recurring authority
    const FUNCTION_LOCKSHOP = 'LOCKSHOP'; // Parcel shop
    const FUNCTION_LOCKTV = 'LOCKTV'; // Appointment
    const FUNCTION_LOCKZBK = 'LOCKZBK'; //Delivery to mail-/parcelbox (without signature)


    const MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER1 = 35;
    const MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER2 = 35;
    const MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER3 = 35;
    const MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER4 = 35;
    const MAX_LENGTH_CONTENT = 50;
    const MAX_LENGTH_PARAMETER = 300;
    const MAX_LENGTH_INFO1 = 29;
    const MAX_LENGTH_INFO2 = 30;
    const MAX_LENGTH_PARCEL_CLASS = 50;

    const MAX_HAZARDOUS_COUNT = 4;

    const MIN_VOLUME = 1001001;
    const MAX_VOLUME = 999999999;
    const MAX_WEIGHT = 99999999;
    const MAX_MESSAGE_NUMBER = 99999;

    const PATTERN_PARCEL_LABEL_NUMBER = '/^.{11,14}$/u';

    /**
     * Parcel label number. Number range and validity are checked.
     * @var string
     */
    protected string $parcelLabelNumber;

    /**
     * Parcel customer reference number 1.
     * @var string
     */
    protected string $customerReferenceNumber1;

    /**
     * Parcel customer reference number 2.
     * @var string
     */
    protected string $customerReferenceNumber2;

    /**
     * Parcel customer reference number 3.
     * @var string
     */
    protected string $customerReferenceNumber3;

    /**
     * Parcel customer reference number 4.
     * @var string
     */
    protected string $customerReferenceNumber4;

    /**
     * Specifies if this parcel is a consignment swap parcel. Default value is false.
     * @var bool
     */
    protected bool $swap;

    /**
     * Volume of the single parcel (length/width/height in format LLLWWWHHH) in cm without separators.
     * @var int
     */
    protected int $volume;

    /**
     * Parcel weight in grams rounded in 10 gram units without decimal point (e.g. 300 equals 3kg).
     * Consignment allows 8-digit values, collection requests 7-digit and dangerous goods 6-digit.
     * @var int
     */
    protected int $weight;

    /**
     * Specifies if this parcel is a limited quantities hazardous goods parcel.
     * Default value is false.
     * @var bool
     */
    protected bool $hazardousLimitedQuantities = false;

    /**
     * Specifies if this parcel has increased insurance value. Default value is false.
     * @var HigherInsurance
     */
    protected HigherInsurance $higherInsurance;

    /**
     * Content of this parcel, mandatory for increased insurance.
     * For collection requests maximum length is 50, for consignment it is 35.
     * @var string
     */
    protected string $content;

    /**
     * Additional service.
     * Possible values are:
     * 1 = Delivery information,
     * 2 = Documents return,
     * 3 = Written permission to deposit goods by sender,
     * 4 = Department delivery,
     * 5 = Online permission to deposit goods,
     * 6 = Parcel box,
     * 7 = Information at indoor scanning,
     * 8 = Locking out-for-delivery.
     * @var int
     */
    protected int $addService;

    /**
     * Message number for consignment shipper information. Default value is 1.
     * @var int
     */
    protected int $messageNumber = 1;

    /**
     * Blockable functions. Possible values are:
     * LOCKDZB = Delivery to a third party with notification of delivery,
     * LOCKASG = Written permission to deposit goods,
     * LOCKEVM = Delivery with non-recurring authority,
     * LOCKSHOP = Parcel shop,
     * LOCKTV = Appointment,
     * LOCKZBK = Delivery to mail-/parcelbox (without signature).
     * @var string
     */
    protected string $function;

    /**
     * Free text for blockable functions.
     * @var string
     */
    protected string $parameter;

    /**
     * Contains packing and substance data for dangerous goods.
     * @var Hazardous[]
     */
    protected array $hazardous;

    /**
     * Flag for determining if content of parameter info1 will be added on the label of a collection request parcel.
     * Default value is false.
     * @var bool
     */
    protected bool $printInfo1OnParcelLabel = false;

    /**
     * Information text 1.
     * This will be printed on the parcel label if the flag printInfo1OnParcellabel is set to true.
     * @var string
     */
    protected string $info1;

    /**
     * Information text 2. This will not be printed on the parcel label.
     * @var string
     */
    protected string $info2;

    /**
     * Specifies if parcel is a return parcel.
     * Default value is false.
     * @var bool
     */
    protected bool $returns = false;

    /**
     * Parcel class.
     * See Parcelclass in MPSEXPDATA specification for valid values.
     * @var string
     */
    protected string $parcelClass;

    /**
     * @return string|null
     */
    public function getParcelLabelNumber(): ?string
    {
        return $this->parcelLabelNumber ?? null;
    }

    /**
     * @param string $parcelLabelNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setParcelLabelNumber(string $parcelLabelNumber): static
    {
        if (!preg_match(self::PATTERN_PARCEL_LABEL_NUMBER, $parcelLabelNumber)) {
            throw new WrongArgumentException(
                sprintf('parcelLabelNumber pattern mismatch, entered %s', $parcelLabelNumber)
            );
        }

        $this->parcelLabelNumber = $parcelLabelNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerReferenceNumber1(): ?string
    {
        return $this->customerReferenceNumber1 ?? null;
    }

    /**
     * @param string $customerReferenceNumber1
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomerReferenceNumber1(string $customerReferenceNumber1): static
    {
        if (mb_strlen($customerReferenceNumber1) > self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER1) {
            throw new WrongArgumentException(
                sprintf(
                    'max length customerReferenceNumber1 is %d',
                    self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER1
                )
            );
        }

        $this->customerReferenceNumber1 = $customerReferenceNumber1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerReferenceNumber2(): ?string
    {
        return $this->customerReferenceNumber2 ?? null;
    }

    /**
     * @param string $customerReferenceNumber2
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomerReferenceNumber2(string $customerReferenceNumber2): static
    {
        if (mb_strlen($customerReferenceNumber2) > self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER2) {
            throw new WrongArgumentException(
                sprintf(
                    'max length customerReferenceNumber2 is %d',
                    self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER2
                )
            );
        }

        $this->customerReferenceNumber2 = $customerReferenceNumber2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerReferenceNumber3(): ?string
    {
        return $this->customerReferenceNumber3 ?? null;
    }

    /**
     * @param string $customerReferenceNumber3
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomerReferenceNumber3(string $customerReferenceNumber3): static
    {
        if (mb_strlen($customerReferenceNumber3) > self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER3) {
            throw new WrongArgumentException(
                sprintf(
                    'max length customerReferenceNumber3 is %d',
                    self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER3
                )
            );
        }

        $this->customerReferenceNumber3 = $customerReferenceNumber3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerReferenceNumber4(): ?string
    {
        return $this->customerReferenceNumber4 ?? null;
    }

    /**
     * @param string $customerReferenceNumber4
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomerReferenceNumber4(string $customerReferenceNumber4): static
    {
        if (mb_strlen($customerReferenceNumber4) > self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER4) {
            throw new WrongArgumentException(
                sprintf(
                    'max length customerReferenceNumber4 is %d',
                    self::MAX_LENGTH_CUSTOMER_REFERENCE_NUMBER4
                )
            );
        }

        $this->customerReferenceNumber4 = $customerReferenceNumber4;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isSwap(): ?bool
    {
        return $this->swap ?? null;
    }

    /**
     * @return bool|null
     */
    public function getSwap(): ?bool
    {
        return $this->swap ?? null;
    }

    /**
     * @param bool $swap
     * @return static
     */
    public function setSwap(bool $swap): static
    {
        $this->swap = $swap;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getVolume(): ?int
    {
        return $this->volume ?? null;
    }

    /**
     * @param int $volume
     * @return static
     * @throws WrongArgumentException
     */
    public function setVolume(int $volume): static
    {
        if ($volume > self::MAX_VOLUME || $volume < self::MIN_VOLUME) {
            throw new WrongArgumentException(
                sprintf('volume should be in 1001001 - 999999999, entered %d', $volume)
            );
        }

        $this->volume = $volume;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight ?? null;
    }

    /**
     * @param int $weight
     * @return static
     * @throws WrongArgumentException
     */
    public function setWeight(int $weight): static
    {
        if ($weight > self::MAX_WEIGHT) {
            throw new WrongArgumentException(
                sprintf('max weight value is %d', self::MAX_WEIGHT)
            );
        }

        $this->weight = $weight;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHazardousLimitedQuantities(): bool
    {
        return $this->hazardousLimitedQuantities;
    }

    /**
     * @return bool
     */
    public function getHazardousLimitedQuantities(): bool
    {
        return $this->hazardousLimitedQuantities;
    }

    /**
     * @param bool $hazardousLimitedQuantities
     * @return static
     */
    public function setHazardousLimitedQuantities(bool $hazardousLimitedQuantities): static
    {
        $this->hazardousLimitedQuantities = $hazardousLimitedQuantities;
        return $this;
    }

    /**
     * @return HigherInsurance|null
     */
    public function getHigherInsurance(): ?HigherInsurance
    {
        return $this->higherInsurance ?? null;
    }

    /**
     * @param HigherInsurance $higherInsurance
     * @return static
     */
    public function setHigherInsurance(HigherInsurance $higherInsurance): static
    {
        $this->higherInsurance = $higherInsurance;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content ?? null;
    }

    /**
     * @param string $content
     * @return static
     * @throws WrongArgumentException
     */
    public function setContent(string $content): static
    {
        if (mb_strlen($content) > self::MAX_LENGTH_CONTENT) {
            throw new WrongArgumentException(
                sprintf('max length content is %d', self::MAX_LENGTH_CONTENT)
            );
        }

        $this->content = $content;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAddService(): ?int
    {
        return $this->addService ?? null;
    }

    /**
     * @param int $addService
     * @return static
     * @throws WrongArgumentException
     */
    public function setAddService(int $addService): static
    {
        if (!in_array($addService, $allowedList = $this->getAllowedAddServiceList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed addService is %s, entered %s',
                    implode(', ', $allowedList),
                    $addService
                )
            );
        }

        $this->addService = $addService;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceDeliveryInformation(): static
    {
        $this->addService = self::ADD_SERVICE_DELIVERY_INFORMATION;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceDocumentsReturn(): static
    {
        $this->addService = self::ADD_SERVICE_DOCUMENTS_RETURN;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceWrittenPermissions(): static
    {
        $this->addService = self::ADD_SERVICE_WRITTEN_PERMISSIONS;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceDepartmentDelivery(): static
    {
        $this->addService = self::ADD_SERVICE_DEPARTMENT_DELIVERY;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceOnlinePermission(): static
    {
        $this->addService = self::ADD_SERVICE_ONLINE_PERMISSION;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceParcelBox(): static
    {
        $this->addService = self::ADD_SERVICE_PARCEL_BOX;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceInformationAtIndoorScanning(): static
    {
        $this->addService = self::ADD_SERVICE_INFORMATION_AT_INDOOR_SCANNING;
        return $this;
    }

    /**
     * @return static
     */
    public function setAddServiceLockingOutForDelivery(): static
    {
        $this->addService = self::ADD_SERVICE_LOCKING_OUT_FOR_DELIVERY;
        return $this;
    }

    /**
     * @return int
     */
    public function getMessageNumber(): int
    {
        return $this->messageNumber;
    }

    /**
     * @param int $messageNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setMessageNumber(int $messageNumber): static
    {
        if ($messageNumber > self::MAX_MESSAGE_NUMBER) {
            throw new WrongArgumentException(
                sprintf('max messageNumber value is %d', self::MAX_MESSAGE_NUMBER)
            );
        }

        $this->messageNumber = $messageNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFunction(): ?string
    {
        return $this->function ?? null;
    }

    /**
     * @param string $function
     * @return static
     * @throws WrongArgumentException
     */
    public function setFunction(string $function): static
    {
        if (!in_array($function, $allowedList = $this->getAllowedFunctionList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed function is %s, entered %s',
                    implode(', ', $allowedList),
                    $function
                )
            );
        }

        $this->function = $function;
        return $this;
    }

    /**
     * Delivery to a third party with notification of delivery
     * @return static
     */
    public function setFunctionLockDzb(): static
    {
        $this->function = self::FUNCTION_LOCKDZB;
        return $this;
    }

    /**
     * Written permission to deposit goods
     * @return static
     */
    public function setFunctionLockAsg(): static
    {
        $this->function = self::FUNCTION_LOCKASG;
        return $this;
    }

    /**
     * Delivery with non-recurring authority
     * @return static
     */
    public function setFunctionLockEvm(): static
    {
        $this->function = self::FUNCTION_LOCKEVM;
        return $this;
    }

    /**
     * Parcel shop
     * @return static
     */
    public function setFunctionLockShop(): static
    {
        $this->function = self::FUNCTION_LOCKSHOP;
        return $this;
    }

    /**
     * Appointment
     * @return static
     */
    public function setFunctionLockTv(): static
    {
        $this->function = self::FUNCTION_LOCKTV;
        return $this;
    }

    /**
     * Delivery to mail-/parcelbox (without signature).
     * @return static
     */
    public function setFunctionLockZbk(): static
    {
        $this->function = self::FUNCTION_LOCKZBK;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParameter(): ?string
    {
        return $this->parameter ?? null;
    }

    /**
     * @param string $parameter
     * @return static
     * @throws WrongArgumentException
     */
    public function setParameter(string $parameter): static
    {
        if (mb_strlen($parameter) > self::MAX_LENGTH_PARAMETER) {
            throw new WrongArgumentException(
                sprintf('max length parameter is %d', self::MAX_LENGTH_PARAMETER)
            );
        }

        $this->parameter = $parameter;
        return $this;
    }

    /**
     * @return Hazardous[]
     */
    public function getHazardous(): array
    {
        return $this->hazardous ?? [];
    }

    /**
     * @param Hazardous[] $hazardous
     * @return static
     * @throws WrongArgumentException
     */
    public function setHazardous(array $hazardous): static
    {
        if (count($hazardous) > self::MAX_HAZARDOUS_COUNT) {
            throw new WrongArgumentException(
                sprintf('max count hazardous is %d', self::MAX_HAZARDOUS_COUNT)
            );
        }

        $this->hazardous = $hazardous;
        return $this;
    }

    /**
     * @param Hazardous $hazardous
     * @return static
     * @throws WrongArgumentException
     */
    public function addHazardous(Hazardous $hazardous): static
    {
        if (count($this->getHazardous()) >= self::MAX_HAZARDOUS_COUNT) {
            throw new WrongArgumentException(
                sprintf('max count hazardous is %d', self::MAX_HAZARDOUS_COUNT)
            );
        }
        $this->hazardous[] = $hazardous;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrintInfo1OnParcelLabel(): bool
    {
        return $this->printInfo1OnParcelLabel;
    }

    /**
     * @return bool
     */
    public function getPrintInfo1OnParcelLabel(): bool
    {
        return $this->printInfo1OnParcelLabel;
    }

    /**
     * @param bool $printInfo1OnParcelLabel
     * @return static
     */
    public function setPrintInfo1OnParcelLabel(bool $printInfo1OnParcelLabel): static
    {
        $this->printInfo1OnParcelLabel = $printInfo1OnParcelLabel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInfo1(): ?string
    {
        return $this->info1 ?? null;
    }

    /**
     * @param string $info1
     * @return static
     * @throws WrongArgumentException
     */
    public function setInfo1(string $info1): static
    {
        if (mb_strlen($info1) > self::MAX_LENGTH_INFO1) {
            throw new WrongArgumentException(
                sprintf('max length info1 is %d', self::MAX_LENGTH_INFO1)
            );
        }

        $this->info1 = $info1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInfo2(): ?string
    {
        return $this->info2 ?? null;
    }

    /**
     * @param string $info2
     * @return static
     * @throws WrongArgumentException
     */
    public function setInfo2(string $info2): static
    {
        if (mb_strlen($info2) > self::MAX_LENGTH_INFO2) {
            throw new WrongArgumentException(
                sprintf('max length info2 is %d', self::MAX_LENGTH_INFO2)
            );
        }

        $this->info2 = $info2;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReturns(): bool
    {
        return $this->returns;
    }

    /**
     * @return bool
     */
    public function getReturns(): bool
    {
        return $this->returns;
    }

    /**
     * @param bool $returns
     * @return static
     */
    public function setReturns(bool $returns): static
    {
        $this->returns = $returns;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParcelClass(): ?string
    {
        return $this->parcelClass ?? null;
    }

    /**
     * @param string $parcelClass
     * @return static
     * @throws WrongArgumentException
     */
    public function setParcelClass(string $parcelClass): static
    {
        if (mb_strlen($parcelClass) > self::MAX_LENGTH_PARCEL_CLASS) {
            throw new WrongArgumentException(
                sprintf('max length parcelClass is %d', self::MAX_LENGTH_PARCEL_CLASS)
            );
        }

        $this->parcelClass = $parcelClass;
        return $this;
    }
    
    /**
     * @return int[]
     */
    public function getAllowedAddServiceList(): array
    {
        return [
            self::ADD_SERVICE_DELIVERY_INFORMATION,
            self::ADD_SERVICE_DOCUMENTS_RETURN,
            self::ADD_SERVICE_WRITTEN_PERMISSIONS,
            self::ADD_SERVICE_DEPARTMENT_DELIVERY,
            self::ADD_SERVICE_ONLINE_PERMISSION,
            self::ADD_SERVICE_PARCEL_BOX,
            self::ADD_SERVICE_INFORMATION_AT_INDOOR_SCANNING,
            self::ADD_SERVICE_LOCKING_OUT_FOR_DELIVERY
        ];
    }

    /**
     * @return string[]
     */
    public function getAllowedFunctionList(): array
    {
        return [
            self::FUNCTION_LOCKDZB,
            self::FUNCTION_LOCKASG,
            self::FUNCTION_LOCKEVM,
            self::FUNCTION_LOCKSHOP,
            self::FUNCTION_LOCKTV,
            self::FUNCTION_LOCKZBK
        ];
    }
}