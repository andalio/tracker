<?php

namespace App\Infrastructure\EventListener;

use App\Application\Service\AllowedDomainService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CorsListener
{
    public function __construct(private AllowedDomainService $allowedDomainService)
    {
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $origin = $request->headers->get('Origin');

        if (!str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        if (!$origin || !$this->allowedDomainService->isRefererAllowed($origin)) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setContent(json_encode(['error' => 'Forbidden: CORS policy does not allow this origin.']));
            $response->headers->set('Content-Type', 'application/json');
            return;
        }

        $response->headers->set('Access-Control-Allow-Origin', $origin);
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        if ($request->isMethod('OPTIONS')) {
            $response->setStatusCode(204);
            $response->setContent('');
            $event->setResponse($response);
        }
    }
}