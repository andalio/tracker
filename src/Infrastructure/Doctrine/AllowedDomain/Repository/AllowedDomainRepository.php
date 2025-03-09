<?php

namespace App\Infrastructure\Doctrine\AllowedDomain\Repository;

use App\Domain\AllowedDomain\AllowedDomain;
use App\Domain\AllowedDomain\AllowedDomainRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class AllowedDomainRepository implements AllowedDomainRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function isAllowed(string $domain): bool
    {
        return $this->entityManager->getRepository(AllowedDomain::class)->count([
                AllowedDomain::DOMAIN_FIELD => $domain,
                AllowedDomain::ACTIVE_FIELD => true,
            ]) > 0;
    }
}