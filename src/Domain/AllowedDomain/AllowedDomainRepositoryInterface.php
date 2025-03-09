<?php

namespace App\Domain\AllowedDomain;

interface AllowedDomainRepositoryInterface
{
    public function isAllowed(string $domain): bool;
}