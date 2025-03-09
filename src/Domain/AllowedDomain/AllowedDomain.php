<?php

namespace App\Domain\AllowedDomain;

class AllowedDomain
{
    public const DOMAIN_FIELD = "domain";
    public const ACTIVE_FIELD = "active";

    private int $id;
    private string $domain;
    private bool $active;
    private \DateTime $created;

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setCreatedTimestamp(): self
    {
        $this->created = new \DateTime();

        return $this;
    }
}
