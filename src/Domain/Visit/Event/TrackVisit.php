<?php

namespace App\Domain\Visit\Event;

class TrackVisit
{
    public function __construct(
        private string $pageUrl,
        private string $userHash,
        private string $visitDate
    ) {
    }

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }

    public function getUserHash(): string
    {
        return $this->userHash;
    }

    public function getVisitDate(): string
    {
        return $this->visitDate;
    }

}