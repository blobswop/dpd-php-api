<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles express international data. */
class International
{
    const CUSTOMS_TERMS_DAP_CLEARED = '01';
    const CUSTOMS_TERMS_DDP_EXCLUDE_TAXES = '02';
    const CUSTOMS_TERMS_DDP_INCLUDED_TAXES = '03';
    const CUSTOMS_TERMS_EX_WORKS = '05';
    const CUSTOMS_TERMS_DAP = '06';
    const CUSTOMS_TERMS_DAP_ENHANCED = '07';

    const CUSTOMS_PAPER_COMMERCIAL_INVOICE = 'A';
    const CUSTOMS_PAPER_PROFORMA_INVOICE = 'B';
    const CUSTOMS_PAPER_EXPORT_DECLARATION = 'C';
    const CUSTOMS_PAPER_EUR1 = 'D';
    const CUSTOMS_PAPER_EUR2 = 'E';
    const CUSTOMS_PAPER_ATR = 'F';
    const CUSTOMS_PAPER_DELIVERY_NOTE = 'G';
    const CUSTOMS_PAPER_THIRD_PARTY_BILLING = 'H';
    const CUSTOMS_PAPER_T1_DOCUMENT = 'I';

    const LINEHAUL_AIR = 'AI';
    const LINEHAUL_ROAD = 'RO';

    const MAX_LENGTH_CUSTOMS_INVOICE = 20;
    const MAX_LENGTH_CUSTOMS_ORDER = 25;
    const MAX_LENGTH_SHIP_MRN = 20;
    const MAX_LENGTH_COMMENT1 = 70;
    const MAX_LENGTH_COMMENT2 = 70;
    const MAX_LENGTH_COUNTRY_REGISTRATION_NUMBER = 15;
    const MAX_LENGTH_COMMERCIAL_INVOICE_CONSIGNEE_VAT_NUMBER = 20;

    const MAX_CUSTOMS_AMOUNT = 999999999999999;
    const MAX_CUSTOMS_AMOUNT_EXPORT =  999999999999999;
    const MAX_CUSTOMS_INVOICE_DATE = 99999999;
    const MAX_INVOICE_POSITION = 999999;
    const MAX_NUMBER_OF_ARTICLE = 99;

    const MAX_ADDITIONAL_INVOICE_LINES_COUNT = 99;

    const PATTERN_CUSTOMS_CURRENCY = '/^[A-Z]{3}$/u';
    const PATTERN_CUSTOMS_CURRENCY_EXPORT = '/^[A-Z]{3}$/u';
    const PATTERN_CUSTOMS_ORIGIN = '/^[A-Z]$/u';
    const PATTERN_COMMERCIAL_INVOICE_CONSIGNOR_VAT_NUMBER = '/^[A-Z]{2}\w{1,15}$/u';

    /**
     * Specifies if the type of this parcel is "Documents" (allowed for air based destination only), not by default.
     * @var bool
     */
    protected bool $parcelType;

    /**
     * Declared customs amount (in invoice currency) in total
     * with two decimal digits without separator (e.g. 14.00 = 1400),
     * for "Documents" it is set to 0.
     * @var int
     */
    protected int $customsAmount;

    /**
     * Invoice currency code in ISO 4217 alpha 3 format.
     * @var string
     */
    protected string $customsCurrency;

    /**
     * Converted customs amount (in export currency) in total
     * with two decimal digits without separator (14,00 = 1400),
     * for "Documents" it is set to 0.
     * @var int
     */
    protected int $customsAmountExport;

    /**
     * Export currency code in ISO 4217 alpha 3 format.
     * @var string
     */
    protected string $customsCurrencyExport;

    /**
     * Declares the customs terms.
     * Possible values are:
     * 01 = DAP, cleared,
     * 02 = DDP, delivered duty paid (incl. duties and excl. taxes),
     * 03 = DDP, delivered duty paid (incl. duties and taxes),
     * 05 = Ex works (EXW),
     * 06 = DAP
     * 07 = DAP enhanced, duty and taxes were pre-paid
     * by the receiver.
     * @var string
     */
    protected string $customsTerms;

    /**
     * Declares accompanying documents without separator (e.g. "ABG"), composed by following values:
     * A = Commercial invoice,
     * B = Pro forma invoice,
     * C = Export declaration,
     * D = EUR1,
     * E = EUR2,
     * F = ATR,
     * G = Delivery note,
     * H = Third party billing,
     * I = T1 document.
     * @var string
     */
    protected string $customsPaper;

    /**
     * Specifies if the accompanying documents are at the parcel or not (not by default).
     * @var bool
     */
    protected bool $customsEnclosure;

    /**
     * Declares the invoice number.
     * @var string
     */
    protected string $customsInvoice;

    /**
     * Declares the invoice date in format YYYYMMDD.
     * @var int
     */
    protected int $customsInvoiceDate;

    /**
     * Origin country in ISO 3166 alpha 2 format (e.g. DE, EN).
     * @var string
     */
    protected string $customsOrigin;

    /**
     * Central customs order number for collective customs clearance.
     * @var string
     */
    protected string $customsOrder;

    /**
     * Declares mode of line haul, possible values are "AI" for Air or "RO" for Road.
     * @var string
     */
    protected string $linehaul;

    /**
     * Movement reference number of the electronical export declaration.
     * @var string
     */
    protected string $shipMrn;

    /**
     * Flag for determining collective customs clearance. Default value is false.
     * @var bool
     */
    protected bool $collectiveCustomsClearance;

    /**
     * Declares the invoice position.
     * @var int
     */
    protected int $invoicePosition;

    /**
     * Comment.
     * @var string
     */
    protected string $comment1;

    /**
     * Second comment.
     * @var string
     */
    protected string $comment2;

    /**
     * Real number of commodities. The number of additionalInvoiceLines must be equal to this value.
     * @var int
     */
    protected int $numberOfArticle;

    /**
     * Destination country registration information: Registration number or FDA.
     * @var string
     */
    protected string $countryRegistrationNumber;

    /**
     * Declares the commercial invoice consignee VAT number.
     * @var string
     */
    protected string $commercialInvoiceConsigneeVatNumber;

    /**
     * Contains address data of commercial invoice consignee.
     * @var AddressWithBusinessUnit
     */
    protected AddressWithBusinessUnit $commercialInvoiceConsignee;

    /**
     * Declares the commercial invoice consignor VAT/ EORI number.
     * @var string
     */
    protected string $commercialInvoiceConsignorVatNumber;

    /**
     * Contains address data of commercial invoice consignor.
     * @var Address
     */
    protected Address $commercialInvoiceConsignor;

    /**
     * Contains additional invoice lines.
     * @var AdditionalInvoiceLine[]
     */
    protected array $additionalInvoiceLines;

    /**
     * @return bool|null
     */
    public function isParcelType(): ?bool
    {
        return $this->parcelType ?? null;
    }

    /**
     * @return bool|null
     */
    public function getParcelType(): ?bool
    {
        return $this->parcelType ?? null;
    }

    /**
     * @param bool $parcelType
     * @return static
     */
    public function setParcelType(bool $parcelType): static
    {
        $this->parcelType = $parcelType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsAmount(): ?int
    {
        return $this->customsAmount ?? null;
    }

    /**
     * @param int $customsAmount
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsAmount(int $customsAmount): static
    {
        if ($customsAmount > self::MAX_CUSTOMS_AMOUNT) {
            throw new WrongArgumentException(
                sprintf('max customsAmount value is %d', self::MAX_CUSTOMS_AMOUNT)
            );
        }

        $this->customsAmount = $customsAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsCurrency(): ?string
    {
        return $this->customsCurrency ?? null;
    }

    /**
     * @param string $customsCurrency
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsCurrency(string $customsCurrency): static
    {
        if (!preg_match(self::PATTERN_CUSTOMS_CURRENCY, $customsCurrency)) {
            throw new WrongArgumentException(
                sprintf('customsCurrency pattern mismatch, entered %s', $customsCurrency)
            );
        }

        $this->customsCurrency = $customsCurrency;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsAmountExport(): ?int
    {
        return $this->customsAmountExport ?? null;
    }

    /**
     * @param int $customsAmountExport
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsAmountExport(int $customsAmountExport): static
    {
        if ($customsAmountExport > self::MAX_CUSTOMS_AMOUNT_EXPORT) {
            throw new WrongArgumentException(
                sprintf('max customsAmountExport value is %d', self::MAX_CUSTOMS_AMOUNT_EXPORT)
            );
        }

        $this->customsAmountExport = $customsAmountExport;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsCurrencyExport(): ?string
    {
        return $this->customsCurrencyExport ?? null;
    }

    /**
     * @param string $customsCurrencyExport
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsCurrencyExport(string $customsCurrencyExport): static
    {
        if (!preg_match(self::PATTERN_CUSTOMS_CURRENCY_EXPORT, $customsCurrencyExport)) {
            throw new WrongArgumentException(
                sprintf('customsCurrencyExport pattern mismatch, entered %s', $customsCurrencyExport)
            );
        }

        $this->customsCurrencyExport = $customsCurrencyExport;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsTerms(): ?string
    {
        return $this->customsTerms ?? null;
    }

    /**
     * @param string $customsTerms
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsTerms(string $customsTerms): static
    {
        if (!in_array($customsTerms, $allowedList = $this->getAllowedCustomsTermsList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed customsTerms is %s, entered %s',
                    implode(', ', $allowedList),
                    $customsTerms
                )
            );
        }

        $this->customsTerms = $customsTerms;
        return $this;
    }

    /**
     * @return static
     */
    public function setCustomsTermsDapCleared(): static
    {
        $this->customsTerms = self::CUSTOMS_TERMS_DAP_CLEARED;
        return $this;
    }

    /**
     * @return static
     */
    public function setCustomsTermsDdpExcludeTaxes(): static
    {
        $this->customsTerms = self::CUSTOMS_TERMS_DDP_EXCLUDE_TAXES;
        return $this;
    }

    /**
     * @return static
     */
    public function setCustomsTermsDdpIncludeTaxes(): static
    {
        $this->customsTerms = self::CUSTOMS_TERMS_DDP_INCLUDED_TAXES;
        return $this;
    }

    /**
     * @return static
     */
    public function setCustomsTermsExWorks(): static
    {
        $this->customsTerms = self::CUSTOMS_TERMS_EX_WORKS;
        return $this;
    }

    /**
     * @return static
     */
    public function setCustomsTermsDap(): static
    {
        $this->customsTerms = self::CUSTOMS_TERMS_DAP;
        return $this;
    }

    /**
     * @return static
     */
    public function setCustomsTermsDapEnhanced(): static
    {
        $this->customsTerms = self::CUSTOMS_TERMS_DAP_ENHANCED;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsPaper(): ?string
    {
        return $this->customsPaper ?? null;
    }

    /**
     * @param string $customsPaper
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsPaper(string $customsPaper): static
    {
        array_map(function ($customsPaperItem) {
            if (!in_array($customsPaperItem, $allowedList = $this->getAllowedCustomsPaperList())) {
                throw new WrongArgumentException(
                    sprintf(
                        'allowed customsPaper items is %s, entered %s',
                        implode(', ', $allowedList),
                        $customsPaperItem
                    )
                );
            }
        }, mb_str_split($customsPaper));

        $this->customsPaper = $customsPaper;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperCommercialInvoice(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_COMMERCIAL_INVOICE;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperProformaInvoice(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_PROFORMA_INVOICE;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperExportDeclaration(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_EXPORT_DECLARATION;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperEur1(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_EUR1;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperEur2(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_EUR2;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperAtr(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_ATR;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperDeliveryNote(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_DELIVERY_NOTE;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperThirdPartyBilling(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_THIRD_PARTY_BILLING;
        return $this;
    }

    /**
     * @return static
     */
    public function addCustomsPaperT1Document(): static
    {
        $this->customsPaper = ($this->customsPaper ?? '') . self::CUSTOMS_PAPER_T1_DOCUMENT;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCustomsEnclosure(): ?bool
    {
        return $this->customsEnclosure ?? null;
    }

    /**
     * @return bool|null
     */
    public function getCustomsEnclosure(): ?bool
    {
        return $this->customsEnclosure ?? null;
    }

    /**
     * @param bool $customsEnclosure
     * @return static
     */
    public function setCustomsEnclosure(bool $customsEnclosure): static
    {
        $this->customsEnclosure = $customsEnclosure;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsInvoice(): ?string
    {
        return $this->customsInvoice ?? null;
    }

    /**
     * @param string $customsInvoice
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsInvoice(string $customsInvoice): static
    {
        if (mb_strlen($customsInvoice) > self::MAX_LENGTH_CUSTOMS_INVOICE) {
            throw new WrongArgumentException(
                sprintf('max length customsInvoice is %d', self::MAX_LENGTH_CUSTOMS_INVOICE)
            );
        }

        $this->customsInvoice = $customsInvoice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsInvoiceDate(): ?int
    {
        return $this->customsInvoiceDate ?? null;
    }

    /**
     * @param int $customsInvoiceDate
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsInvoiceDate(int $customsInvoiceDate): static
    {
        if ($customsInvoiceDate > self::MAX_CUSTOMS_INVOICE_DATE) {
            throw new WrongArgumentException(
                sprintf('max customsInvoiceDate value is %d', self::MAX_CUSTOMS_INVOICE_DATE)
            );
        }

        $this->customsInvoiceDate = $customsInvoiceDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsOrigin(): ?string
    {
        return $this->customsOrigin ?? null;
    }

    /**
     * @param string $customsOrigin
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsOrigin(string $customsOrigin): static
    {
        if (!preg_match(self::PATTERN_CUSTOMS_ORIGIN, $customsOrigin)) {
            throw new WrongArgumentException(
                sprintf('customsOrigin pattern mismatch, entered %s', $customsOrigin)
            );
        }

        $this->customsOrigin = $customsOrigin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsOrder(): ?string
    {
        return $this->customsOrder ?? null;
    }

    /**
     * @param string $customsOrder
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsOrder(string $customsOrder): static
    {
        if (mb_strlen($customsOrder) > self::MAX_LENGTH_CUSTOMS_ORDER) {
            throw new WrongArgumentException(
                sprintf('max length customsOrder is %d', self::MAX_LENGTH_CUSTOMS_ORDER)
            );
        }

        $this->customsOrder = $customsOrder;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLinehaul(): ?string
    {
        return $this->linehaul ?? null;
    }

    /**
     * @param string $linehaul
     * @return static
     */
    public function setLinehaul(string $linehaul): static
    {
        if (!in_array($linehaul, $allowedList = $this->getAllowedLinehaulList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed linehaul is %s, entered %s',
                    implode(', ', $allowedList),
                    $linehaul
                )
            );
        }

        $this->linehaul = $linehaul;
        return $this;
    }

    /**
     * @return static
     */
    public function setLinehaulAir(): static
    {
        $this->linehaul = self::LINEHAUL_AIR;
        return $this;
    }

    /**
     * @return static
     */
    public function setLinehaulRoad(): static
    {
        $this->linehaul = self::LINEHAUL_ROAD;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShipMrn(): ?string
    {
        return $this->shipMrn ?? null;
    }

    /**
     * @param string $shipMrn
     * @return static
     * @throws WrongArgumentException
     */
    public function setShipMrn(string $shipMrn): static
    {
        if (mb_strlen($shipMrn) > self::MAX_LENGTH_SHIP_MRN) {
            throw new WrongArgumentException(
                sprintf('max length shipMrn is %d', self::MAX_LENGTH_SHIP_MRN)
            );
        }

        $this->shipMrn = $shipMrn;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCollectiveCustomsClearance(): ?bool
    {
        return $this->collectiveCustomsClearance ?? null;
    }

    /**
     * @return bool|null
     */
    public function getCollectiveCustomsClearance(): ?bool
    {
        return $this->collectiveCustomsClearance ?? null;
    }

    /**
     * @param bool $collectiveCustomsClearance
     * @return static
     */
    public function setCollectiveCustomsClearance(bool $collectiveCustomsClearance): static
    {
        $this->collectiveCustomsClearance = $collectiveCustomsClearance;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInvoicePosition(): ?int
    {
        return $this->invoicePosition ?? null;
    }

    /**
     * @param int $invoicePosition
     * @return static
     * @throws WrongArgumentException
     */
    public function setInvoicePosition(int $invoicePosition): static
    {
        if ($invoicePosition > self::MAX_INVOICE_POSITION) {
            throw new WrongArgumentException(
                sprintf('max invoicePosition value is %d', self::MAX_INVOICE_POSITION)
            );
        }

        $this->invoicePosition = $invoicePosition;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment1(): ?string
    {
        return $this->comment1 ?? null;
    }

    /**
     * @param string $comment1
     * @return static
     * @throws WrongArgumentException
     */
    public function setComment1(string $comment1): static
    {
        if (mb_strlen($comment1) > self::MAX_LENGTH_COMMENT1) {
            throw new WrongArgumentException(
                sprintf('max length comment1 is %d', self::MAX_LENGTH_COMMENT1)
            );
        }

        $this->comment1 = $comment1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment2(): ?string
    {
        return $this->comment2 ?? null;
    }

    /**
     * @param string $comment2
     * @return static
     * @throws WrongArgumentException
     */
    public function setComment2(string $comment2): static
    {
        if (mb_strlen($comment2) > self::MAX_LENGTH_COMMENT2) {
            throw new WrongArgumentException(
                sprintf('max length comment2 is %d', self::MAX_LENGTH_COMMENT2)
            );
        }

        $this->comment2 = $comment2;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberOfArticle(): ?int
    {
        return $this->numberOfArticle ?? null;
    }

    /**
     * @param int $numberOfArticle
     * @return static
     * @throws WrongArgumentException
     */
    public function setNumberOfArticle(int $numberOfArticle): static
    {
        if ($numberOfArticle > self::MAX_NUMBER_OF_ARTICLE) {
            throw new WrongArgumentException(
                sprintf('max numberOfArticle value is %d', self::MAX_NUMBER_OF_ARTICLE)
            );
        }

        $this->numberOfArticle = $numberOfArticle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryRegistrationNumber(): ?string
    {
        return $this->countryRegistrationNumber ?? null;
    }

    /**
     * @param string $countryRegistrationNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setCountryRegistrationNumber(string $countryRegistrationNumber): static
    {
        if (mb_strlen($countryRegistrationNumber) > self::MAX_LENGTH_COMMENT1) {
            throw new WrongArgumentException(
                sprintf(
                    'max length countryRegistrationNumber is %d',
                    self::MAX_LENGTH_COUNTRY_REGISTRATION_NUMBER
                )
            );
        }

        $this->countryRegistrationNumber = $countryRegistrationNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommercialInvoiceConsigneeVatNumber(): ?string
    {
        return $this->commercialInvoiceConsigneeVatNumber ?? null;
    }

    /**
     * @param string $commercialInvoiceConsigneeVatNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setCommercialInvoiceConsigneeVatNumber(string $commercialInvoiceConsigneeVatNumber): static
    {
        if (mb_strlen($commercialInvoiceConsigneeVatNumber) > self::MAX_LENGTH_COMMERCIAL_INVOICE_CONSIGNEE_VAT_NUMBER) {
            throw new WrongArgumentException(
                sprintf(
                    'max length commercialInvoiceConsigneeVatNumber is %d',
                    self::MAX_LENGTH_COMMERCIAL_INVOICE_CONSIGNEE_VAT_NUMBER
                )
            );
        }

        $this->commercialInvoiceConsigneeVatNumber = $commercialInvoiceConsigneeVatNumber;
        return $this;
    }

    /**
     * @return AddressWithBusinessUnit|null
     */
    public function getCommercialInvoiceConsignee(): ?AddressWithBusinessUnit
    {
        return $this->commercialInvoiceConsignee ?? null;
    }

    /**
     * @param AddressWithBusinessUnit $commercialInvoiceConsignee
     * @return static
     */
    public function setCommercialInvoiceConsignee(AddressWithBusinessUnit $commercialInvoiceConsignee): static
    {
        $this->commercialInvoiceConsignee = $commercialInvoiceConsignee;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommercialInvoiceConsignorVatNumber(): ?string
    {
        return $this->commercialInvoiceConsignorVatNumber ?? null;
    }

    /**
     * @param string $commercialInvoiceConsignorVatNumber
     * @return static
     * @throws WrongArgumentException
     */
    public function setCommercialInvoiceConsignorVatNumber(string $commercialInvoiceConsignorVatNumber): static
    {
        if (!preg_match(
            self::PATTERN_COMMERCIAL_INVOICE_CONSIGNOR_VAT_NUMBER,
            $commercialInvoiceConsignorVatNumber
        )) {
            throw new WrongArgumentException(
                sprintf(
                    'commercialInvoiceConsignorVatNumber pattern mismatch, entered %s',
                    $commercialInvoiceConsignorVatNumber
                )
            );
        }

        $this->commercialInvoiceConsignorVatNumber = $commercialInvoiceConsignorVatNumber;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getCommercialInvoiceConsignor(): ?Address
    {
        return $this->commercialInvoiceConsignor ?? null;
    }

    /**
     * @param Address $commercialInvoiceConsignor
     * @return static
     */
    public function setCommercialInvoiceConsignor(Address $commercialInvoiceConsignor): static
    {
        $this->commercialInvoiceConsignor = $commercialInvoiceConsignor;
        return $this;
    }

    /**
     * @return AdditionalInvoiceLine[]|null
     */
    public function getAdditionalInvoiceLines(): ?array
    {
        return $this->additionalInvoiceLines ?? null;
    }

    /**
     * @param AdditionalInvoiceLine[] $additionalInvoiceLines
     * @return static
     * @throws WrongArgumentException
     */
    public function setAdditionalInvoiceLines(array $additionalInvoiceLines): static
    {
        if (count($additionalInvoiceLines) > self::MAX_ADDITIONAL_INVOICE_LINES_COUNT) {
            throw new WrongArgumentException(
                sprintf(
                    'max count additionalInvoiceLines is %d',
                    self::MAX_ADDITIONAL_INVOICE_LINES_COUNT
                )
            );
        }

        $this->additionalInvoiceLines = $additionalInvoiceLines;
        return $this;
    }

    /**
     * @param AdditionalInvoiceLine $additionalInvoiceLine
     * @return static
     * @throws WrongArgumentException
     */
    public function addAdditionalInvoiceLine(AdditionalInvoiceLine $additionalInvoiceLine): static
    {
        if (count($this->additionalInvoiceLines ?? []) >= self::MAX_ADDITIONAL_INVOICE_LINES_COUNT) {
            throw new WrongArgumentException(
                sprintf(
                    'max count additionalInvoiceLines is %d',
                    self::MAX_ADDITIONAL_INVOICE_LINES_COUNT
                )
            );
        }

        $this->additionalInvoiceLines[] = $additionalInvoiceLine;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllowedCustomsTermsList(): array
    {
        return [
            self::CUSTOMS_TERMS_DAP_CLEARED,
            self::CUSTOMS_TERMS_DDP_EXCLUDE_TAXES,
            self::CUSTOMS_TERMS_DDP_INCLUDED_TAXES,
            self::CUSTOMS_TERMS_EX_WORKS,
            self::CUSTOMS_TERMS_DAP,
            self::CUSTOMS_TERMS_DAP_ENHANCED
        ];
    }

    /**
     * @return string[]
     */
    public function getAllowedCustomsPaperList(): array
    {
        return [
            self::CUSTOMS_PAPER_COMMERCIAL_INVOICE,
            self::CUSTOMS_PAPER_PROFORMA_INVOICE,
            self::CUSTOMS_PAPER_EXPORT_DECLARATION,
            self::CUSTOMS_PAPER_EUR1,
            self::CUSTOMS_PAPER_EUR2,
            self::CUSTOMS_PAPER_ATR,
            self::CUSTOMS_PAPER_DELIVERY_NOTE,
            self::CUSTOMS_PAPER_THIRD_PARTY_BILLING,
            self::CUSTOMS_PAPER_T1_DOCUMENT
        ];
    }

    /**
     * @return string[]
     */
    public function getAllowedLinehaulList(): array
    {
        return [
            self::LINEHAUL_AIR,
            self::LINEHAUL_ROAD
        ];
    }
}