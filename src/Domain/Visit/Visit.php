<?php

namespace App\Domain\Visit;

class Visit
{
    public const ALIAS = 'v';

    public const ID_FIELD = 'id';
    public const PAGE_URL_FIELD = 'pageUrl';
    public const USER_HASH_FIELD = 'userHash';
    public const VISIT_DATE_FIELD = 'visitDate';

    private int $id;
    private string $pageUrl;
    private string $userHash;
    private \DateTime $visitDate;
    private \DateTime $created;

    public function __construct(string $pageUrl, string $userHash, \DateTime $visitDate)
    {
        $this->pageUrl = $pageUrl;
        $this->userHash = $userHash;
        $this->visitDate = $visitDate;
    }

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }

    public function getUserHash(): string
    {
        return $this->userHash;
    }

    public function getVisitDate(): \DateTime
    {
        return $this->visitDate;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreatedTimestamp(): self
    {
        $this->created = new \DateTime();

        return $this;
    }
}