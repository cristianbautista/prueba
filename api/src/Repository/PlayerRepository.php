<?php

namespace App\Repository;

use App\Entity\Player;

class PlayerRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Player::class;
    }

    public function save(Player $player)
    {
        $this->saveEntity($player);
    }

    public function getTotalSalaryByClub(int $id): array
    {
        return $this->objectRepository->findBy(['idclub' => $id]);
    }

    public function getPlayerByName(string $name): ?object
    {
        return $this->objectRepository->findOneBy(['name' => $name]);
    }

    public function getPlayersByTeam(int $idTeam)
    {
        $sql = 'SELECT p, c
            FROM App\Entity\Player p
            INNER JOIN p.idclub c
            WHERE p.idclub = :id';
        $query = $this->getEntityManager()->createQuery(
            $sql
        )->setParameter('id', $idTeam);
        return $query->getResult();
    }

    public function getPlayerByNameAndTeam(?int $idTeam, $namePlayer)
    {
        $sql = 'SELECT p, c
            FROM App\Entity\Player p
            INNER JOIN p.idclub c
            WHERE p.idclub = :id AND p.name = :name';
        $query = $this->getEntityManager()->createQuery(
            $sql
        )->setParameter('id', $idTeam)
            ->setParameter('name', $namePlayer);
        return $query->getResult();
    }
}
