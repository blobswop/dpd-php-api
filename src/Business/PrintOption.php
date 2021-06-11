<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

/** Options how to return the parcel labels */
class PrintOption
{
    const PAPER_FORMAT_A4 = 'A4';
    const PAPER_FORMAT_A6 = 'A6';
    const PAPER_FORMAT_A7 = 'A7';

    /**
     * The format in which the parcel labels should be returned.
     * PDF, BARCODE_IMAGE, MULTIPAGE_IMAGE as file output; DPL, PDL, ZPL for direct printing.
     * In any case the output is base64 encoded.
     * @var OutputFormatType
     */
    protected OutputFormatType $outputFormat;

    /**
     * Declares the paper format for parcel label print, either "A4", "A6" or "A7".
     * For direct printing must be set to "A6". "A7" only prints return labels.
     * @var string
     */
    protected string $paperFormat;

    /**
     * Information about the printer, if direct printing is enabled.
     * @var Printer
     */
    protected Printer $printer;

    /**
     * The start position of the first parcellabel on the first page, if page format A4 is chosen.
     * Ignored on other paperformats
     * @var StartPosition
     */
    protected StartPosition $startPosition;

    /**
     * @return OutputFormatType|null
     */
    public function getOutputFormat(): ?OutputFormatType
    {
        return $this->outputFormat ?? null;
    }

    /**
     * @param OutputFormatType $outputFormat
     * @return static
     */
    public function setOutputFormat(OutputFormatType $outputFormat): static
    {
        $this->outputFormat = $outputFormat;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaperFormat(): ?string
    {
        return $this->paperFormat ?? null;
    }

    /**
     * @param string $paperFormat
     * @return static
     * @throws WrongArgumentException
     */
    public function setPaperFormat(string $paperFormat): static
    {
        if (!in_array($paperFormat, $allowedList = $this->getAllowedPaperFormatList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed paperFormat is %s, entered %s',
                    implode(', ', $allowedList),
                    $paperFormat
                )
            );
        }

        $this->paperFormat = $paperFormat;
        return $this;
    }

    /**
     * @return static
     */
    public function setPaperFormatA4(): static
    {
        $this->paperFormat = self::PAPER_FORMAT_A4;
        return $this;
    }

    /**
     * @return static
     */
    public function setPaperFormatA6(): static
    {
        $this->paperFormat = self::PAPER_FORMAT_A6;
        return $this;
    }

    /**
     * @return static
     */
    public function setPaperFormatA7(): static
    {
        $this->paperFormat = self::PAPER_FORMAT_A7;
        return $this;
    }

    /**
     * @return Printer|null
     */
    public function getPrinter(): ?Printer
    {
        return $this->printer ?? null;
    }

    /**
     * @param Printer $printer
     * @return static
     */
    public function setPrinter(Printer $printer): static
    {
        $this->printer = $printer;
        return $this;
    }

    /**
     * @return StartPosition|null
     */
    public function getStartPosition(): ?StartPosition
    {
        return $this->startPosition ?? null;
    }

    /**
     * @param StartPosition $startPosition
     * @return static
     */
    public function setStartPosition(StartPosition $startPosition): static
    {
        $this->startPosition = $startPosition;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllowedPaperFormatList(): array
    {
        return [
            self::PAPER_FORMAT_A4,
            self::PAPER_FORMAT_A6,
            self::PAPER_FORMAT_A7
        ];
    }
}