<?php

namespace App\Services;

use App\Entity\Player;

abstract class BaseService
{
    public function getSalaryTotal(int $idTeam, $repository)
    {
        $total = 0;
        $salaryTotal = $repository->getTotalSalaryByClub($idTeam);
        if (is_array($salaryTotal)) {
            foreach ($salaryTotal as $value) {
                $total += $value->getSalary();
            }
            return $total;
        }
        return $total;
    }

    public function sumTotalSalaryByCoachAndPlayer(int $salaryPlayer = 0, int $salaryCoach = 0): int
    {
        return $salaryPlayer + $salaryCoach;
    }

}
