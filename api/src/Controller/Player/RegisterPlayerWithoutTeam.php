<?php

namespace App\Controller\Player;

use App\Services\Player\PlayerWithoutTeamRegisterService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegisterPlayerWithoutTeam
{
    private PlayerWithoutTeamRegisterService $playerWithoutTeamRegisterService;
    private SerializerInterface $serializer;

    public function __construct(
        PlayerWithoutTeamRegisterService $playerWithoutTeamRegisterService,
        SerializerInterface $serializer
    ) {
        $this->playerWithoutTeamRegisterService = $playerWithoutTeamRegisterService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/create-player-without-team", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->playerWithoutTeamRegisterService->create($request), 'json'),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
}
