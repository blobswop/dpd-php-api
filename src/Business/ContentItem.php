<?php

namespace Dpd\Business;

/** Contains multiple content lines. */
class ContentItem
{
    /**
     * Identifier for content item.
     * @var ContentLine
     */
    protected ContentLine $label;

    /**
     * Content of content item.
     * @var ContentLine[]
     */
    protected mixed $content;

    /**
     * If this field is filled, a link will be created from the content item.
     * @var string
     */
    protected string $linkTarget;

    /**
     * @return ContentLine|null
     */
    public function getLabel(): ?ContentLine
    {
        return $this->label ?? null;
    }

    /**
     * @return ContentLine[]
     */
    public function getContent(): array
    {
        return
            isset($this->content)
                ? (is_object($this->content) ? [$this->content] : $this->content)
                : [];
    }

    /**
     * @return string|null
     */
    public function getLinkTarget(): ?string
    {
        return $this->linkTarget ?? null;
    }
}