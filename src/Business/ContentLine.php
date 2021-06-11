<?php

namespace Dpd\Business;

/** Contains one text line and information about how the text has to be displayed. */
class ContentLine
{
    /**
     * Text element
     * @var string
     */
    protected string $content;

    /**
     * Indicates if text has to be printed bold.
     * @var bool
     */
    protected bool $bold;

    /**
     * Indicates if there has to be a line break after text element.
     * @var bool
     */
    protected bool $paragraph;

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content ?? null;
    }

    /**
     * @return bool
     */
    public function isBold(): bool
    {
        return $this->bold ?? false;
    }

    /**
     * @return bool
     */
    public function getBold(): bool
    {
        return $this->bold ?? false;
    }

    /**
     * @return bool
     */
    public function isParagraph(): bool
    {
        return $this->paragraph ?? false;
    }

    /**
     * @return bool
     */
    public function getParagraph(): bool
    {
        return $this->paragraph ?? false;
    }
}