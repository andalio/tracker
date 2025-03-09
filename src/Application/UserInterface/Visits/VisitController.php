<?php

namespace App\Application\UserInterface\Visits;

use App\Domain\Visit\VisitRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitController extends AbstractController
{
    #[Route('/list', name: "visits_list", methods: ['GET'])]
    public function listVisits(
        Request $request,
        VisitRepositoryInterface $visitRepository
    ): Response {
        $visits = $visitRepository->getUniqueVisitsPerPage(
            $request->query->get('domain'),
            $request->query->get('startDate'),
            $request->query->get('endDate')
        );

        return $this->render('visits/list.html.twig', [
            'visits' => $visits,
            'domain' => $request->query->get('domain'),
            'startDate' => $request->query->get('startDate'),
            'endDate' => $request->query->get('endDate')
        ]);
    }
}