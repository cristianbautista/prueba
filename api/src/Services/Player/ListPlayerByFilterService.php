<?php

namespace App\Services\Player;

use App\Entity\Player;
use App\Repository\ClubRepository;
use App\Repository\CoachRepository;
use App\Repository\PlayerRepository;
use App\Services\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class ListPlayerByFilterService
{
    private ClubRepository $clubRepository;
    private PlayerRepository $playerRepository;
    public function __construct(ClubRepository $clubRepository, PlayerRepository $playerRepository)
    {
        $this->clubRepository = $clubRepository;
        $this->playerRepository = $playerRepository;
    }

    public function execute(Request $request)
    {
        $nameTeam = RequestService::getField($request, 'name');
        $namePlayer = RequestService::getField($request, 'namePlayer', false);
        $idTeam = $this->clubRepository->getIdTeam($nameTeam)->getId();
        if ($namePlayer != null) {
            return  $this->playerRepository->getPlayerByNameAndTeam($idTeam, $namePlayer);
        } else {
            return $this->playerRepository->getPlayersByTeam($idTeam);
        }
    }
}
