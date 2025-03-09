<?php

namespace App\Infrastructure\Doctrine\Visit\Repository;

use App\Domain\Visit\Visit;
use App\Domain\Visit\VisitRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class VisitRepository implements VisitRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Visit $visit): void
    {
        $this->entityManager->persist($visit);
        $this->entityManager->flush();
    }

    public function exists(string $pageUrl, string $userHash, string $visitDate): bool
    {
        return $this->entityManager->getRepository(Visit::class)->count([
                Visit::PAGE_URL_FIELD => $pageUrl,
                Visit::USER_HASH_FIELD => $userHash,
                Visit::VISIT_DATE_FIELD => new \DateTime($visitDate),
            ]) > 0;
    }

    public function getUniqueVisitsPerPage(string $domain, string $startDate, string $endDate): array
    {
        return $this->entityManager
            ->getRepository(Visit::class)
            ->createQueryBuilder(Visit::ALIAS)
            ->select(
                Visit::ALIAS . '.' . Visit::PAGE_URL_FIELD . ',
                COUNT(' . Visit::ALIAS . '.' . Visit::ID_FIELD . ') as total_visits'
            )
            ->where(Visit::ALIAS . '.' . Visit::PAGE_URL_FIELD . ' LIKE :domain')
            ->andWhere(Visit::ALIAS . '.' . Visit::VISIT_DATE_FIELD . ' BETWEEN :startDate AND :endDate')
            ->setParameter('domain', '%' . $domain . '%')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->groupBy(Visit::ALIAS . '.' . Visit::PAGE_URL_FIELD)
            ->orderBy('total_visits', 'DESC')
            ->getQuery()
            ->getResult();
    }
}