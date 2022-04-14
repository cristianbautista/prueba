<?php

namespace App\Repository;

use App\Entity\Club;
use App\Exception\Club\ClubAlreadyExistException;
use Doctrine\ORM\ORMException;

use function PHPUnit\Framework\assertGreaterThanOrEqual;

class ClubRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Club::class;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws ORMException
     */
    public function save(Club $club)
    {
        $this->saveEntity($club);
    }

    public function getPresupposition(string $name): int
    {
        /** @var Club $club */
        $club = $this->objectRepository->findOneBy(["name" => $name]);
        if (null == $club) {
            throw ClubAlreadyExistException::notExistClub($name);
        } elseif ($club->getPresupposition() == null || $club->getPresupposition() == 0) {
            throw ClubAlreadyExistException::fromPresupposition($name);
        }
        return $club->getPresupposition();
    }

    public function getIdTeam(string $nameTeam): Club
    {
        /** @var Club $club */
        $club = $this->objectRepository->findOneBy(["name" => $nameTeam]);
        if (null == $club) {
            throw ClubAlreadyExistException::fromName($nameTeam);
        }
        return $club;
    }
}
