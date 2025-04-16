<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * Finds teams with only one member.
     *
     * @return Team[] Returns an array of Team objects
     */
    public function findTeamsWithOneMember(): array
    {
        return $this->createQueryBuilder('t')
            ->join('t.members', 'm')
            ->groupBy('t.id')
            ->having('COUNT(m.id) = 1')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds a team by its name.
     *
     * @param string $name
     * @return Team|null
     */
    public function findOneByName(string $name): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Finds a team by its tag.
     *
     * @param string $tag
     * @return Team|null
     */
    public function findOneByTag(string $tag): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.tag = :tag')
            ->setParameter('tag', $tag)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
