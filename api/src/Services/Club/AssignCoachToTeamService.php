<?php

namespace App\Services\Club;

use App\Entity\Club;
use App\Entity\Coach;
use App\Exception\Coach\CoachAlreadyExistException;
use App\Exception\Player\ExceedSalaryLimitException;
use App\Repository\ClubRepository;
use App\Repository\CoachRepository;
use App\Repository\PlayerRepository;
use App\Services\BaseService;
use App\Services\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class AssignCoachToTeamService extends BaseService
{
    private PlayerRepository $playerRepository;
    private CoachRepository $coachRepository;
    private ClubRepository $clubRepository;
    public function __construct(
        PlayerRepository $playerRepository,
        CoachRepository $coachRepository,
        ClubRepository $clubRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->coachRepository = $coachRepository;
        $this->clubRepository = $clubRepository;
    }

    public function create(Request $request)
    {
        $name = RequestService::getField($request, 'name');
        $nameTeam = RequestService::getField($request, 'nameTeam');
        $salary = RequestService::getField($request, 'salary');

        $presupposition = $this->clubRepository->getPresupposition($nameTeam);
        $coach = $this->newCoach($name, $salary, $this->clubRepository->getIdTeam($nameTeam));

        $this->existsCoach($name);
        $totalWithSalaryPlayers = $this->getSalaryTotal(
            $coach->getIdclub()->getId(),
            $this->playerRepository
        );
        $totalWithSalaryCoach = $this->getSalaryTotal(
            $coach->getIdclub()->getId(),
            $this->coachRepository
        );
        if ($this->sumTotalSalaryByCoachAndPlayer($totalWithSalaryPlayers, $totalWithSalaryCoach) == 0) {
            $coach->setSalary($salary);
        } elseif (
            $this->sumTotalSalaryByCoachAndPlayer(
                $totalWithSalaryPlayers,
                $totalWithSalaryCoach
            ) < $presupposition
        ) {
            $coach->setSalary($salary);
        } else {
            throw ExceedSalaryLimitException::fromName($name);
        }
        return $coach;
    }

    private function newCoach(string $name, int $salary, Club $club): Coach
    {
        $coach = new Coach();
        $coach->setName($name);
        $coach->setSalary($salary);
        $coach->setIdclub($club);
        return $coach;
    }

    private function existsCoach(string $name)
    {
        if ($this->coachRepository->getPlayerByName($name)) {
            throw CoachAlreadyExistException::fromName($name);
        }
    }
}
