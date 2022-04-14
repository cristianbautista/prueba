<?php

namespace App\Controller\Club;

use App\Services\Club\AssignCoachToTeamService;
use App\Services\Club\AssignPlayerToCoachService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AssignCoachToClub
{
    private AssignCoachToTeamService $assignCoachToTeamService;
    private SerializerInterface $serializer;
    public function __construct(AssignCoachToTeamService $assignPlayerToCoachService, SerializerInterface $serializer)
    {
        $this->assignCoachToTeamService = $assignPlayerToCoachService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/create-coach-to-team", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->assignCoachToTeamService->create($request), 'json'),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
}
