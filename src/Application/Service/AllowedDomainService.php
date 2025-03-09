<?php

namespace App\Application\Service;

use App\Domain\AllowedDomain\AllowedDomainRepositoryInterface;

class AllowedDomainService
{
    public function __construct(private AllowedDomainRepositoryInterface $allowedDomainRepository)
    {
    }

    public function isRefererAllowed(?string $referer): bool
    {
        if (!$referer) {
            return false;
        }

        $parsedUrl = parse_url($referer);
        if (!isset($parsedUrl['host'])) {
            return false;
        }

        $domain = $this->normalizeDomain($parsedUrl['host']);

        return $this->allowedDomainRepository->isAllowed($domain);
    }

    private function normalizeDomain(string $domain): string
    {
        return preg_replace('/^www\./', '', strtolower($domain));
    }
}