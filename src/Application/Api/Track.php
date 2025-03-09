<?php

namespace App\Application\Api;

use App\Domain\Visit\Event\TrackVisit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class Track
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    #[Route('/visit', name: 'track_visit', methods: ['POST'])]
    public function visit(Request $request): JsonResponse
    {
        $trackVisit = $this->serializer->deserialize($request->getContent(), TrackVisit::class, JsonEncoder::FORMAT);

        $this->messageBus->dispatch($trackVisit);

        return new JsonResponse(['message' => 'Visit received'], 202);
    }
}
