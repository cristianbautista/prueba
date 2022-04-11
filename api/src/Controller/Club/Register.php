<?php

namespace App\Controller\Club;

use App\Entity\Club;
use App\Services\Club\ClubRegisterService;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Register
{
    private ClubRegisterService $clubRegisterService;
    private SerializerInterface  $serializer;
    public function __construct(ClubRegisterService $clubRegisterService, SerializerInterface $serializer)
    {
        $this->clubRegisterService = $clubRegisterService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/create-club", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->clubRegisterService->create($request), 'json'),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }
}
