<?php

namespace App\Repository;

use App\Entity\Coach;
use Doctrine\ORM\OptimisticLockException;

class CoachRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Coach::class;
    }

    /**
     * @throws OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Coach $coach)
    {
        $this->saveEntity($coach);
    }

    public function getTotalSalaryByClub(int $id): array
    {
        return $this->objectRepository->findBy(['idclub' => $id]);
    }

    public function getPlayerByName(string $name): ?object
    {
        return $this->objectRepository->findOneBy(['name' => $name]);
    }
}
