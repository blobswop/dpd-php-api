<?php

namespace Dpd\Business;

/** Response object of method getTrackingData. */
class GetTrackingDataResponse
{
    /**
     * Result object with tracking data.
     * @var TrackingResult
     */
    protected TrackingResult $trackingResult;

    /**
     * @return TrackingResult|null
     */
    public function getTrackingResult(): ?TrackingResult
    {
        return $this->trackingResult ?? null;
    }
}