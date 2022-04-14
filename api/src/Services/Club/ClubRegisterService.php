<?php

namespace App\Services\Club;

use App\Entity\Club;
use App\Exception\Club\ClubAlreadyExistException;
use App\Repository\ClubRepository;
use App\Services\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

class ClubRegisterService
{
    private ClubRepository $clubRepository;
    public function __construct(ClubRepository $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }


    public function create(Request $request): Club
    {
        $name = RequestService::getField($request, 'name');
        $presupposition = RequestService::getField($request, 'presupposition');

        $club = new Club();
        $club->setName($name);
        $club->setPresupposition($presupposition);

        try {
            $this->clubRepository->save($club);
        } catch (\Exception $exception) {
            throw ClubAlreadyExistException::fromName($name);
        }
        return $club;
    }
}
