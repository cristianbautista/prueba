<?php

namespace App\Repository;

use App\Entity\Club;

class ClubRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Club::class;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Club $club)
    {
        $this->saveEntity($club);
    }
}
