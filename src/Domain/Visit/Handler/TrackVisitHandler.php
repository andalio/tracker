<?php

namespace App\Domain\Visit\Handler;

use App\Domain\Visit\Event\TrackVisit;
use App\Domain\Visit\Visit;
use App\Domain\Visit\VisitRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TrackVisitHandler
{
    public function __construct(
        private VisitRepositoryInterface $visitRepository
    ) {
    }

    public function __invoke(TrackVisit $event): void
    {
        if ($this->visitRepository->exists($event->getPageUrl(), $event->getUserHash(), $event->getVisitDate())) {
            return;
        }

        $visit = new Visit(
            $event->getPageUrl(),
            $event->getUserHash(),
            new \DateTime($event->getVisitDate()),
        );

        $this->visitRepository->save($visit);
    }
}
