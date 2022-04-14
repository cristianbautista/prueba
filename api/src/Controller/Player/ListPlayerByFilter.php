<?php

namespace App\Controller\Player;

use App\Services\Player\ListPlayerByFilterService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ListPlayerByFilter
{
    private ListPlayerByFilterService $listPlayerByFilterService;
    private SerializerInterface $serializer;
    public function __construct(ListPlayerByFilterService $listPlayerByFilterService, SerializerInterface $serializer)
    {
        $this->listPlayerByFilterService = $listPlayerByFilterService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/list-player-by-filter", methods={"GET"})
     */
    public function register(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->listPlayerByFilterService->execute($request), 'json'),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

}