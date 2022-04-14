<?php

namespace App\Services\Coach;

use App\Entity\Coach;
use App\Exception\Coach\CoachAlreadyExistException;
use App\Repository\CoachRepository;
use App\Services\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class CoachRegisterWithoutTeamService
{
    private CoachRepository $coachRepository;
    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function create(Request $request): Coach
    {
        $name = RequestService::getField($request, 'name');
        $coach = new Coach();
        $coach->setName($name);

        try {
            $this->coachRepository->save($coach);
        } catch (\Exception $exception) {
            throw CoachAlreadyExistException::fromName($name);
        }
        return $coach;
    }
}
