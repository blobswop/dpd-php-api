<?php

namespace Dpd\Business;

use Dpd\Exception\WrongArgumentException;

class StartPosition
{
    const POSITION_UPPER_LEFT = 'UPPER_LEFT';
    const POSITION_UPPER_RIGHT = 'UPPER_RIGHT';
    const POSITION_LOWER_LEFT = 'LOWER_LEFT';
    const POSITION_LOWER_RIGHT = 'LOWER_RIGHT';

    /**
     * @var string
     */
    protected string $startPosition;

    /**
     * @return string|null
     */
    public function getStartPosition(): ?string
    {
        return $this->startPosition ?? null;
    }

    /**
     * @param string $startPosition
     * @return static
     * @throws WrongArgumentException
     */
    public function setStartPosition(string $startPosition): static
    {
        if (!in_array($startPosition, $allowedList = $this->getAllowedStartPositionList())) {
            throw new WrongArgumentException(
                sprintf(
                    'allowed startPosition is %s, entered %s',
                    implode(', ', $allowedList),
                    $startPosition
                )
            );
        }

        $this->startPosition = $startPosition;
        return $this;
    }

    /**
     * @return static
     */
    public function setStartPositionUpperLeft(): static
    {
        $this->startPosition = self::POSITION_UPPER_LEFT;
        return $this;
    }

    /**
     * @return static
     */
    public function setStartPositionUpperRight(): static
    {
        $this->startPosition = self::POSITION_LOWER_RIGHT;
        return $this;
    }

    /**
     * @return static
     */
    public function setStartPositionLowerLeft(): static
    {
        $this->startPosition = self::POSITION_LOWER_LEFT;
        return $this;
    }

    /**
     * @return static
     */
    public function setStartPositionLowerRight(): static
    {
        $this->startPosition = self::POSITION_LOWER_RIGHT;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllowedStartPositionList(): array
    {
        return [
            self::POSITION_UPPER_LEFT,
            self::POSITION_UPPER_RIGHT,
            self::POSITION_LOWER_LEFT,
            self::POSITION_LOWER_RIGHT,
        ];
    }
}