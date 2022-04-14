<?php

namespace App\Services\Club;

use App\Entity\Club;
use App\Entity\Player;
use App\Exception\Player\ExceedSalaryLimitException;
use App\Exception\Player\PlayerAlreadyExistException;
use App\Repository\ClubRepository;
use App\Repository\CoachRepository;
use App\Repository\PlayerRepository;
use App\Services\BaseService;
use App\Services\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Config\Framework\Assets\PackageConfig;

class AssignPlayerToCoachService extends BaseService
{
    private ClubRepository $clubRepository;
    private PlayerRepository $playerRepository;
    private CoachRepository $coachRepository;
    public function __construct(
        ClubRepository $clubRepository,
        PlayerRepository $playerRepository,
        CoachRepository $coachRepository
    ) {
        $this->clubRepository = $clubRepository;
        $this->playerRepository = $playerRepository;
        $this->coachRepository = $coachRepository;
    }

    public function create(Request $request)
    {
        $name = RequestService::getField($request, 'name');
        $dorsal = RequestService::getField($request, 'dorsal');
        $nameTeam = RequestService::getField($request, 'nameTeam');
        $salary = RequestService::getField($request, 'salary');

        $presupposition = $this->clubRepository->getPresupposition($nameTeam);

        $player = $this->createNewPlayer($name, $dorsal, $this->clubRepository->getIdTeam($nameTeam));

        $this->existsPlayer($name);
        $totalWithSalaryPlayers = $this->getSalaryTotal(
            $player->getIdclub()->getId(),
            $this->playerRepository
        );
        $totalWithSalaryCoach = $this->getSalaryTotal(
            $player->getIdclub()->getId(),
            $this->coachRepository
        );

        if ($this->sumTotalSalaryByCoachAndPlayer($totalWithSalaryPlayers, $totalWithSalaryCoach) == 0) {
            $player->setSalary($salary);
        } elseif (
            $this->sumTotalSalaryByCoachAndPlayer(
                $totalWithSalaryPlayers,
                $totalWithSalaryCoach
            ) < $presupposition
        ) {
            $player->setSalary($salary);
        } else {
            throw ExceedSalaryLimitException::fromName($name);
        }
        $this->playerRepository->save($player);

        return $player;
    }


    private function existsPlayer(string $name)
    {
        if ($this->playerRepository->getPlayerByName($name)) {
            throw PlayerAlreadyExistException::fromName($name);
        }
    }

    private function createNewPlayer(string $name, int $dorsal, Club $club): Player
    {
        $player = new Player();
        $player->setName($name);
        $player->setDorsal($dorsal);
        $player->setIdclub($club);
        return $player;
    }
}
