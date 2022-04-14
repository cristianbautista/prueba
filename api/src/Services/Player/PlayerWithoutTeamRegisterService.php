<?php

namespace App\Services\Player;

use App\Entity\Player;
use App\Exception\Player\PlayerAlreadyExistException;
use App\Repository\ClubRepository;
use App\Repository\PlayerRepository;
use App\Services\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class PlayerWithoutTeamRegisterService
{
    private PlayerRepository $playerRepository;

    public function __construct(PlayerRepository $playerRepository, ClubRepository $clubRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function create(Request $request): Player
    {
        $name = RequestService::getField($request, 'name');

        $player = new Player();
        $player->setName($name);

        try {
            $this->playerRepository->save($player);
        } catch (\Exception $exception) {
            throw PlayerAlreadyExistException::fromName($name);
        }
        return $player;
    }
}
