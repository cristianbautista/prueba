<?php


namespace App\Controller\Coach;

use App\Services\Coach\CoachRegisterWithoutTeamService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegisterCoachWithoutTeam
{
    private CoachRegisterWithoutTeamService $coachRegisterWithoutTeamService;
    private SerializerInterface $serializer;
    public function __construct(
        CoachRegisterWithoutTeamService $coachRegisterWithoutTeam,
        SerializerInterface $serializer
    )
    {
        $this->coachRegisterWithoutTeamService = $coachRegisterWithoutTeam;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/create-coach-with-team", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->coachRegisterWithoutTeamService->create($request), 'json'),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
}