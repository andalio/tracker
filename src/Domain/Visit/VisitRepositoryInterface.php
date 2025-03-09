<?php

namespace App\Domain\Visit;

interface VisitRepositoryInterface
{
    public function save(Visit $visit): void;

    public function exists(string $pageUrl, string $userHash, string $visitDate): bool;

    public function getUniqueVisitsPerPage(string $domain, string $startDate, string $endDate): array;
}