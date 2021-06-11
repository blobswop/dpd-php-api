<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Bundles information about an invoice position for international parcels. */
class AdditionalInvoiceLine
{
    const MAX_LENGTH_CUSTOMS_CONTENT = 200;
    const MAX_LENGTH_PRODUCT_FABRIC_COMPOSITION = 200;
    const MAX_LENGTH_PRODUCT_CODE = 255;
    const MAX_LENGTH_PRODUCT_SHORT_DESCRIPTION = 40;

    const MAX_CUSTOMS_INVOICE_POSITION = 999999;
    const MAX_QUANTITY_ITEMS = 9999;
    const MAX_CUSTOMS_AMOUNT_LINE = 999999999999999;
    const MAX_CUSTOMS_ORIGIN = 999;
    CONST MAX_CUSTOMS_NET_WEIGHT = 99999999;
    const MAX_CUSTOMS_GROSS_WEIGHT = 99999999;

    const PATTERN_CUSTOMS_TARIF = '/^[0-9]{8,10}$/u';

    /**
     * Number of invoice position.
     * @var int
     */
    protected int $customsInvoicePosition;

    /**
     * Number of items.
     * @var int
     */
    protected int $quantityItems;

    /**
     * Content.
     * @var string
     */
    protected string $customsContent;

    /**
     * Customs tarif number.
     * @var string
     */
    protected string $customsTarif;

    /**
     * Value of invoice position (in invoice currency) with two decimal digits without separator.
     * @var int
     */
    protected int $customsAmountLine;

    /**
     * Country of invoice origin (ISO 3166).
     * @var int
     */
    protected int $customsOrigin;

    /**
     * Parcel net weight in gramm rounded in 10 gramm units without decimal delimiter (e.g. 300 equals 3kg).
     * @var int
     */
    protected int $customsNetWeight;

    /**
     * Parcel gross weight in gramm rounded in 10 gramm units without decimal delimiter (e.g. 300 equals 3kg).
     * @var int
     */
    protected int $customsGrossWeight;

    /**
     * Description of fabric composition (for DPD DIRECT Servicecode 370).
     * @var string
     */
    protected string $productFabricComposition;

    /**
     * Internal customer product code (for DPD DIRECT Servicecode 370).
     * @var string
     */
    protected string $productCode;

    /**
     * Short description of the product (for DPD DIRECT Servicecode 370).
     * @var string
     */
    protected string $productShortDescription;

    /**
     * @return int|null
     */
    public function getCustomsInvoicePosition(): ?int
    {
        return $this->customsInvoicePosition ?? null;
    }

    /**
     * @param int $customsInvoicePosition
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsInvoicePosition(int $customsInvoicePosition): static
    {
        if ($customsInvoicePosition > self::MAX_CUSTOMS_INVOICE_POSITION) {
            throw new WrongArgumentException(
                sprintf('max customsInvoicePosition value is %d', self::MAX_CUSTOMS_INVOICE_POSITION)
            );
        }

        $this->customsInvoicePosition = $customsInvoicePosition;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantityItems(): ?int
    {
        return $this->quantityItems ?? null;
    }

    /**
     * @param int $quantityItems
     * @return static
     * @throws WrongArgumentException
     */
    public function setQuantityItems(int $quantityItems): static
    {
        if ($quantityItems > self::MAX_QUANTITY_ITEMS) {
            throw new WrongArgumentException(
                sprintf('max quantityItems value is %d', self::MAX_QUANTITY_ITEMS)
            );
        }

        $this->quantityItems = $quantityItems;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsContent(): ?string
    {
        return $this->customsContent ?? null;
    }

    /**
     * @param string $customsContent
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsContent(string $customsContent): static
    {
        if (mb_strlen($customsContent) > self::MAX_LENGTH_CUSTOMS_CONTENT) {
            throw new WrongArgumentException(
                sprintf('max length customsContent is %d', self::MAX_LENGTH_CUSTOMS_CONTENT)
            );
        }

        $this->customsContent = $customsContent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsTarif(): ?string
    {
        return $this->customsTarif ?? null;
    }

    /**
     * @param string $customsTarif
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsTarif(string $customsTarif): static
    {
        if (!preg_match(self::PATTERN_CUSTOMS_TARIF, $customsTarif)) {
            throw new WrongArgumentException(
                sprintf('customsTarif pattern mismatch, entered %s', $customsTarif)
            );
        }

        $this->customsTarif = $customsTarif;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsAmountLine(): ?int
    {
        return $this->customsAmountLine ?? null;
    }

    /**
     * @param int $customsAmountLine
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsAmountLine(int $customsAmountLine): static
    {
        if ($customsAmountLine > self::MAX_CUSTOMS_AMOUNT_LINE) {
            throw new WrongArgumentException(
                sprintf('max customsAmountLine value is %d', self::MAX_CUSTOMS_AMOUNT_LINE)
            );
        }

        $this->customsAmountLine = $customsAmountLine;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsOrigin(): ?int
    {
        return $this->customsOrigin ?? null;
    }

    /**
     * @param int $customsOrigin
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsOrigin(int $customsOrigin): static
    {
        if ($customsOrigin > self::MAX_CUSTOMS_ORIGIN) {
            throw new WrongArgumentException(
                sprintf('max customsOrigin value is %d', self::MAX_CUSTOMS_ORIGIN)
            );
        }

        $this->customsOrigin = $customsOrigin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsNetWeight(): ?int
    {
        return $this->customsNetWeight ?? null;
    }

    /**
     * @param int $customsNetWeight
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsNetWeight(int $customsNetWeight): static
    {
        if ($customsNetWeight > self::MAX_CUSTOMS_NET_WEIGHT) {
            throw new WrongArgumentException(
                sprintf('max customsNetWeight value is %d', self::MAX_CUSTOMS_NET_WEIGHT)
            );
        }

        $this->customsNetWeight = $customsNetWeight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCustomsGrossWeight(): ?int
    {
        return $this->customsGrossWeight ?? null;
    }

    /**
     * @param int $customsGrossWeight
     * @return static
     * @throws WrongArgumentException
     */
    public function setCustomsGrossWeight(int $customsGrossWeight): static
    {
        if ($customsGrossWeight > self::MAX_CUSTOMS_GROSS_WEIGHT) {
            throw new WrongArgumentException(
                sprintf('max customsGrossWeight value is %d', self::MAX_CUSTOMS_GROSS_WEIGHT)
            );
        }

        $this->customsGrossWeight = $customsGrossWeight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductFabricComposition(): ?string
    {
        return $this->productFabricComposition ?? null;
    }

    /**
     * @param string $productFabricComposition
     * @return static
     * @throws WrongArgumentException
     */
    public function setProductFabricComposition(string $productFabricComposition): static
    {
        if (mb_strlen($productFabricComposition) > self::MAX_LENGTH_PRODUCT_FABRIC_COMPOSITION) {
            throw new WrongArgumentException(
                sprintf(
                    'max length productFabricComposition is %d',
                    self::MAX_LENGTH_PRODUCT_FABRIC_COMPOSITION
                )
            );
        }

        $this->productFabricComposition = $productFabricComposition;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductCode(): ?string
    {
        return $this->productCode ?? null;
    }

    /**
     * @param string $productCode
     * @return static
     * @throws WrongArgumentException
     */
    public function setProductCode(string $productCode): static
    {
        if (mb_strlen($productCode) > self::MAX_LENGTH_PRODUCT_CODE) {
            throw new WrongArgumentException(
                sprintf('max length productCode is %d', self::MAX_LENGTH_PRODUCT_CODE)
            );
        }

        $this->productCode = $productCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductShortDescription(): ?string
    {
        return $this->productShortDescription ?? null;
    }

    /**
     * @param string $productShortDescription
     * @return static
     * @throws WrongArgumentException
     */
    public function setProductShortDescription(string $productShortDescription): static
    {
        if (mb_strlen($productShortDescription) > self::MAX_LENGTH_PRODUCT_SHORT_DESCRIPTION) {
            throw new WrongArgumentException(
                sprintf(
                    'max length productShortDescription is %d',
                    self::MAX_LENGTH_PRODUCT_SHORT_DESCRIPTION
                )
            );
        }

        $this->productShortDescription = $productShortDescription;
        return $this;
    }
}