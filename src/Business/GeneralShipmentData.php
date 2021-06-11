<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

class GeneralShipmentData
{
    const PRODUCT_CL = 'CL'; // DPD CLASSIC
    const PRODUCT_E830 = 'E830'; // DPD 8:30
    const PRODUCT_E10 = 'E10'; // DPD 10:00
    const PRODUCT_E12 = 'E12'; // DPD 12:00
    const PRODUCT_E18 = 'E18'; // DPD 18:00
    const PRODUCT_IE2 = 'IE2'; // DPD EXPRESS
    const PRODUCT_MAIL = 'MAIL'; // DPD International Mail
    const PRODUCT_MAX = 'MAX'; // DPD MAX
    const PRODUCT_PL = 'PL'; // DPD PARCELLetter
    const PRODUCT_PM4 = 'PM4'; // DPD Priority

    const MAX_LENGTH_MPS_ID = 25;
    const MAX_LENGTH_C_USER = 10;
    const MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER1 = 50;
    const MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER2 = 35;
    const MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER3 = 35;
    const MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER4 = 35;
    const MAX_LENGTH_IDENTIFICATION_NUMBER = 999;

    const MAX_MPS_VOLUME = 999999999;
    const MAX_MPS_WEIGHT = 99999999;

    const PATTERN_SENDING_DEPOT = '/^[a-z0-9]{4}$/u';
    const PATTERN_MPS_EXPECTED_SENDING_DATE = '/^[2][0-9]{3}([0][0-9]|[1][0-2])(0[1-9]|[12][0-9]|3[01])$/u';
    const PATTERN_MPS_EXPECTED_SENDING_TIME = '/^(([1][0-9]|[2][0-3]|[0][0-9])([0-5][0-9])([0-5][0-9]))|([0-9]([0-5][0-9])([0-5][0-9]))$/u';

    /**
     * The shipment number for consignment data.
     * The shipment number is only accepted if the parcel label number is allocated by customer.
     * It starts with one of "MPS", "EXP" or "B2C", the last eight ciphers are the date in format YYYYMMDD.
     * @var string
     */
    protected string $mpsId;

    /**
     * User ID of the person who made the entry.
     * @var string
     */
    protected string $cUser;

    /**
     * Consignment customer reference number 1 (maximal length 35),
     * also customer reference number for collection request orders (maximal length 50).
     * @var string
     */
    protected string $mpsCustomerReferenceNumber1;

    /**
     * Consignment customer reference number 2.
     * @var string
     */
    protected string $mpsCustomerReferenceNumber2;

    /**
     * Consignment customer reference number 3.
     * @var string
     */
    protected string $mpsCustomerReferenceNumber3;

    /**
     * Consignment customer reference number 4.
     * @var string
     */
    protected string $mpsCustomerReferenceNumber4;

    /**
     * Serves as unique alphanumeric key of the shipment used by customer.
     * @var string
     */
    protected string $identificationNumber;

    /**
     * Sending depot for consignment, ordering depot for collection request,
     * customer's depot for pickup information or creating/ sending depot for dangerous goods.
     * Four alphanumeric positions, including leading zeros, e.g. 0163.
     * @var string
     */
    protected string $sendingDepot;

    /**
     * Selection of product, exactly one per shipment, mandatory for consignment data.
     * Possible values are:
     * CL = DPD CLASSIC
     * E830 = DPD 8:30
     * E10 = DPD 10:00
     * E12 = DPD 12:00
     * E18 = DPD 18:00
     * IE2 = DPD EXPRESS
     * MAIL = DPD International Mail
     * MAX = DPD MAX
     * PL = DPD PARCELLetter
     * PM4 = DPD Priority
     * @var string
     */
    protected string $product;

    /**
     * Specifies if this shipment should be sent as complete delivery.
     * Default value is false.
     * @var bool
     */
    protected bool $mpsCompleteDelivery = false;

    /**
     * Specifies if the label for complete delivery is printed for pickup.
     * Default value is false.
     * @var bool
     */
    protected bool $mpsCompleteDeliveryLabel = false;

    /**
     * Volume per consignment in cm3 (without positions after the decimal point).
     * @var int
     */
    protected int $mpsVolume;

    /**
     * Shipment weight in grams rounded in 10 gram units without decimal point (e.g. 300 equals 3kg).
     * @var int
     */
    protected int $mpsWeight;

    /**
     * Date when the shipment is expected to be transferred to the system. Format is YYYYMMDD.
     * @var string
     */
    protected string $mpsExpectedSendingDate;

    /**
     * Time when the shipment is expected to be transferred to the system. Format is HHMMSS.
     * @var string
     */
    protected string $mpsExpectedSendingTime;

    /**
     * Consignment sender's address, collection request customer's address or pickup information customer's address.
     * @var AddressWithType
     */
    protected AddressWithType $sender;

    /**
     * Address of the recipient. For parcel shop delivery address of the real recipient.
     * @var AddressWithType
     */
    protected AddressWithType $recipient;

    /**
     * Address of the return parcel. It is currently not used.
     * @var AddressWithType
     */
    protected AddressWithType $returnAddress;

    /**
     * @return string|null
     */
    public function getMpsId(): ?string
    {
        return $this->mpsId ?? null;
    }

    /**
     * @param string $mpsId
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsId(string $mpsId): static
    {
        if (mb_strlen($mpsId) > self::MAX_LENGTH_MPS_ID) {
            throw new WrongArgumentException(
                sprintf('max length mpsId is %d', self::MAX_LENGTH_MPS_ID)
            );
        }

        $this->mpsId = $mpsId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCUser(): ?string
    {
        return $this->cUser ?? null;
    }

    /**
     * @param string $cUser
     * @return static
     * @throws WrongArgumentException
     */
    public function setCUser(string $cUser): static
    {
        if (mb_strlen($cUser) > self::MAX_LENGTH_C_USER) {
            throw new WrongArgumentException(
                sprintf('max length cUser is %d', self::MAX_LENGTH_C_USER)
            );
        }

        $this->cUser = $cUser;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpsCustomerReferenceNumber1(): ?string
    {
        return $this->mpsCustomerReferenceNumber1 ?? null;
    }

    /**
     * @param string $mpsCustomerReferenceNumber1
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsCustomerReferenceNumber1(string $mpsCustomerReferenceNumber1): static
    {
        if (mb_strlen($mpsCustomerReferenceNumber1) > self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER1) {
            throw new WrongArgumentException(
                sprintf(
                    'max length mpsCustomerReferenceNumber1 is %d',
                    self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER1
                )
            );
        }

        $this->mpsCustomerReferenceNumber1 = $mpsCustomerReferenceNumber1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpsCustomerReferenceNumber2(): ?string
    {
        return $this->mpsCustomerReferenceNumber2 ?? null;
    }

    /**
     * @param string $mpsCustomerReferenceNumber2
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsCustomerReferenceNumber2(string $mpsCustomerReferenceNumber2): static
    {
        if (mb_strlen($mpsCustomerReferenceNumber2) > self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER2) {
            throw new WrongArgumentException(
                sprintf(
                    'max length mpsCustomerReferenceNumber2 is %d',
                    self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER2
                )
            );
        }

        $this->mpsCustomerReferenceNumber2 = $mpsCustomerReferenceNumber2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpsCustomerReferenceNumber3(): ?string
    {
        return $this->mpsCustomerReferenceNumber3 ?? null;
    }

    /**
     * @param string $mpsCustomerReferenceNumber3
     * @return static
     */
    public function setMpsCustomerReferenceNumber3(string $mpsCustomerReferenceNumber3): static
    {
        if (mb_strlen($mpsCustomerReferenceNumber3) > self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER3) {
            throw new WrongArgumentException(
                sprintf(
                    'max length mpsCustomerReferenceNumber3 is %d',
                    self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER3
                )
            );
        }

        $this->mpsCustomerReferenceNumber3 = $mpsCustomerReferenceNumber3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpsCustomerReferenceNumber4(): ?string
    {
        return $this->mpsCustomerReferenceNumber4 ?? null;
    }

    /**
     * @param string $mpsCustomerReferenceNumber4
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsCustomerReferenceNumber4(string $mpsCustomerReferenceNumber4): static
    {
        if (mb_strlen($mpsCustomerReferenceNumber4) > self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER4) {
            throw new WrongArgumentException(
                sprintf(
                    'max length mpsCustomerReferenceNumber4 is %d',
                    self::MAX_LENGTH_MPS_CUSTOMER_REFERENCE_NUMBER4
                )
            );
        }

        $this->mpsCustomerReferenceNumber4 = $mpsCustomerReferenceNumber4;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdentificationNumber(): ?string
    {
        return $this->identificationNumber ?? null;
    }

    /**
     * @param string $identificationNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setIdentificationNumber(string $identificationNumber): static
    {
        if (mb_strlen($identificationNumber) > self::MAX_LENGTH_IDENTIFICATION_NUMBER) {
            throw new WrongArgumentException(
                sprintf(
                    'max length identificationNumber is %d',
                    self::MAX_LENGTH_IDENTIFICATION_NUMBER
                )
            );
        }

        $this->identificationNumber = $identificationNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSendingDepot(): ?string
    {
        return $this->sendingDepot ?? null;
    }

    /**
     * @param string $sendingDepot
     * @return static
     * @throws WrongArgumentException
     */
    public function setSendingDepot(string $sendingDepot): static
    {
        if (!preg_match(self::PATTERN_SENDING_DEPOT, $sendingDepot)) {
            throw new WrongArgumentException(
                sprintf(
                    'sendingDepot should be f1our alphanumeric positions, '
                    . 'including leading zeros, e.g. 0163, entered %s',
                    $sendingDepot
                )
            );
        }

        $this->sendingDepot = $sendingDepot;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProduct(): ?string
    {
        return $this->product ?? null;
    }

    /**
     * @param string $product
     * @return static
     * @throws WrongArgumentException
     */
    public function setProduct(string $product): static
    {
        if (!in_array($product, $allowedList = $this->getAllowedProductList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed product is %s, entered %s',
                    implode(', ', $allowedList),
                    $product
                )
            );
        }

        $this->product = $product;
        return $this;
    }

    /**
     * DPD CLASSIC
     * @return static
     */
    public function setProductDpdClassic(): static
    {
        $this->product = self::PRODUCT_CL;
        return $this;
    }

    /**
     * DPD 8:30
     * @return static
     */
    public function setProductDpd830(): static
    {
        $this->product = self::PRODUCT_E830;
        return $this;
    }

    /**
     * DPD 10:00
     * @return static
     */
    public function setProductDpd10(): static
    {
        $this->product = self::PRODUCT_E10;
        return $this;
    }

    /**
     * DPD 12:00
     * @return static
     */
    public function setProductDpd12(): static
    {
        $this->product = self::PRODUCT_E12;
        return $this;
    }

    /**
     * DPD 18:00
     * @return static
     */
    public function setProductDpd18(): static
    {
        $this->product = self::PRODUCT_E18;
        return $this;
    }

    /**
     * DPD EXPRESS
     * @return static
     */
    public function setProductDpdExpress(): static
    {
        $this->product = self::PRODUCT_IE2;
        return $this;
    }

    /**
     * DPD International Mail
     * @return static
     */
    public function setProductDpdInternationalMail(): static
    {
        $this->product = self::PRODUCT_MAIL;
        return $this;
    }

    /**
     * DPD MAX
     * @return static
     */
    public function setProductDpdMax(): static
    {
        $this->product = self::PRODUCT_MAX;
        return $this;
    }

    /**
     * DPD PARCELLetter
     * @return static
     */
    public function setProductDpdParcelLetter(): static
    {
        $this->product = self::PRODUCT_PL;
        return $this;
    }

    /**
     * DPD Priority
     * @return static
     */
    public function setProductDpdPriority(): static
    {
        $this->product = self::PRODUCT_PM4;
        return $this;
    }

    /**
     * @return bool
     */
    public function getMpsCompleteDelivery(): bool
    {
        return $this->mpsCompleteDelivery;
    }

    /**
     * @return bool
     */
    public function isMpsCompleteDelivery(): bool
    {
        return $this->mpsCompleteDelivery;
    }

    /**
     * @param bool $mpsCompleteDelivery
     * @return static
     */
    public function setMpsCompleteDelivery(bool $mpsCompleteDelivery): static
    {
        $this->mpsCompleteDelivery = $mpsCompleteDelivery;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMpsCompleteDeliveryLabel(): bool
    {
        return $this->mpsCompleteDeliveryLabel;
    }

    /**
     * @return bool
     */
    public function getMpsCompleteDeliveryLabel(): bool
    {
        return $this->mpsCompleteDeliveryLabel;
    }

    /**
     * @param bool $mpsCompleteDeliveryLabel
     * @return static
     */
    public function setMpsCompleteDeliveryLabel(bool $mpsCompleteDeliveryLabel): static
    {
        $this->mpsCompleteDeliveryLabel = $mpsCompleteDeliveryLabel;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMpsVolume(): ?int
    {
        return $this->mpsVolume ?? null;
    }

    /**
     * @param int $mpsVolume
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsVolume(int $mpsVolume): static
    {
        if ($mpsVolume > self::MAX_MPS_VOLUME) {
            throw new WrongArgumentException(
                sprintf('max mpsVolume value is %d', self::MAX_MPS_VOLUME)
            );
        }

        $this->mpsVolume = $mpsVolume;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMpsWeight(): ?int
    {
        return $this->mpsWeight ?? null;
    }

    /**
     * @param int $mpsWeight
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsWeight(int $mpsWeight): static
    {
        if ($mpsWeight > self::MAX_MPS_WEIGHT) {
            throw new WrongArgumentException(
                sprintf('max mpsWeight value is %d', self::MAX_MPS_WEIGHT)
            );
        }

        $this->mpsWeight = $mpsWeight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpsExpectedSendingDate(): ?string
    {
        return $this->mpsExpectedSendingDate ?? null;
    }

    /**
     * @param string $mpsExpectedSendingDate
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsExpectedSendingDate(string $mpsExpectedSendingDate): static
    {
        if (!preg_match(self::PATTERN_MPS_EXPECTED_SENDING_DATE, $mpsExpectedSendingDate)) {
            throw new WrongArgumentException(
                sprintf(
                    'mpsExpectedSendingDate should be format YYYYMMDD, entered %s',
                    $mpsExpectedSendingDate
                )
            );
        }

        $this->mpsExpectedSendingDate = $mpsExpectedSendingDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMpsExpectedSendingTime(): ?string
    {
        return $this->mpsExpectedSendingTime ?? null;
    }

    /**
     * @param string $mpsExpectedSendingTime
     * @return static
     * @throws WrongArgumentException
     */
    public function setMpsExpectedSendingTime(string $mpsExpectedSendingTime): static
    {
        if (!preg_match(self::PATTERN_MPS_EXPECTED_SENDING_TIME, $mpsExpectedSendingTime)) {
            throw new WrongArgumentException(
                sprintf(
                    'mpsExpectedSendingTime should be format HHMMSS, entered %s',
                    $mpsExpectedSendingTime
                )
            );
        }

        $this->mpsExpectedSendingTime = $mpsExpectedSendingTime;
        return $this;
    }

    /**
     * @return AddressWithType|null
     */
    public function getSender(): ?AddressWithType
    {
        return $this->sender ?? null;
    }

    /**
     * @param AddressWithType $sender
     * @return static
     */
    public function setSender(AddressWithType $sender): static
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return AddressWithType|null
     */
    public function getRecipient(): ?AddressWithType
    {
        return $this->recipient ?? null;
    }

    /**
     * @param AddressWithType $recipient
     * @return static
     */
    public function setRecipient(AddressWithType $recipient): static
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return AddressWithType|null
     */
    public function getReturnAddress(): ?AddressWithType
    {
        return $this->returnAddress ?? null;
    }

    /**
     * @param AddressWithType $returnAddress
     * @return static
     */
    public function setReturnAddress(AddressWithType $returnAddress): static
    {
        $this->returnAddress = $returnAddress;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllowedProductList(): array
    {
        return [
            self::PRODUCT_CL,
            self::PRODUCT_E830,
            self::PRODUCT_E10,
            self::PRODUCT_E12,
            self::PRODUCT_E18,
            self::PRODUCT_IE2,
            self::PRODUCT_MAIL,
            self::PRODUCT_MAX,
            self::PRODUCT_PL,
            self::PRODUCT_PM4
        ];
    }
}