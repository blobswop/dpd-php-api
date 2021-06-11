<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Information about the printer, if direct printing is used. */
class Printer
{
    const CONNECTION_TYPE_SERIAL = 'SERIAL';
    const CONNECTION_TYPE_PARALLEL = 'PARALLEL';

    /**
     * The printer's manufacturer. At the moment only for informational purposes.
     * @var string
     */
    protected string $manufacturer;

    /**
     * The printer's model. At the moment only for informational purposes.
     * @var string
     */
    protected string $model;

    /**
     * The printer's revision / version. At the moment only for informational purposes.
     * @var string
     */
    protected string $revision;

    /**
     * The horizontal offset in mm for the direct printer file (Not used with normal PDF output).
     * @var float
     */
    protected float $offsetX;

    /**
     * The vertical offset in mm for the direct printer file (Not used with normal PDF output).
     * @var float
     */
    protected float $offsetY;

    /**
     * The connection type of the printer: serial or parallel connection.
     * @var string
     */
    protected string $connectionType;

    /**
     * If the printer can print AZTEC barcodes, set this flag to true.
     * @var bool
     */
    protected bool $barcodeCapable2D;

    /**
     * @return string|null
     */
    public function getManufacturer(): ?string
    {
        return $this->manufacturer ?? null;
    }

    /**
     * @param string $manufacturer
     * @return static
     */
    public function setManufacturer(string $manufacturer): static
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model ?? null;
    }

    /**
     * @param string $model
     * @return static
     */
    public function setModel(string $model): static
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRevision(): ?string
    {
        return $this->revision ?? null;
    }

    /**
     * @param string $revision
     * @return static
     */
    public function setRevision(string $revision): static
    {
        $this->revision = $revision;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getOffsetX(): ?float
    {
        return $this->offsetX ?? null;
    }

    /**
     * @param float $offsetX
     * @return static
     */
    public function setOffsetX(float $offsetX): static
    {
        $this->offsetX = $offsetX;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getOffsetY(): ?float
    {
        return $this->offsetY ?? null;
    }

    /**
     * @param float $offsetY
     * @return static
     */
    public function setOffsetY(float $offsetY): static
    {
        $this->offsetY = $offsetY;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConnectionType(): ?string
    {
        return $this->connectionType ?? null;
    }

    /**
     * @param string $connectionType
     * @return static
     * @throws WrongArgumentException
     */
    public function setConnectionType(string $connectionType): static
    {
        if (!in_array($connectionType, $allowedList = $this->getConnectionTypeAllowedList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed connectionType is %s, entered %s',
                    implode(', ', $allowedList),
                    $connectionType
                )
            );
        }

        $this->connectionType = $connectionType;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isBarcodeCapable2D(): ?bool
    {
        return $this->barcodeCapable2D ?? null;
    }

    /**
     * @param bool $barcodeCapable2D
     * @return static
     */
    public function setBarcodeCapable2D(bool $barcodeCapable2D): static
    {
        $this->barcodeCapable2D = $barcodeCapable2D;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getConnectionTypeAllowedList(): array
    {
        return [
            self::CONNECTION_TYPE_SERIAL,
            self::CONNECTION_TYPE_PARALLEL
        ];
    }
}