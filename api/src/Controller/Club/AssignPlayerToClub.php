<?php

namespace App\Controller\Club;

use App\Services\Club\AssignPlayerToCoachService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AssignPlayerToClub
{
    private AssignPlayerToCoachService $assignPlayerToCoachService;
    private SerializerInterface $serializer;
    public function __construct(AssignPlayerToCoachService $assignPlayerToCoachService, SerializerInterface $serializer)
    {
        $this->assignPlayerToCoachService = $assignPlayerToCoachService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/create-player-to-team", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->assignPlayerToCoachService->create($request), 'json'),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
}
