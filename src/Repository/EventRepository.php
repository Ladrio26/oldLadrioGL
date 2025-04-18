<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return Event[] Returns an array of future Event objects
     */
    public function findFutureEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFutureEventsByGame(string $game): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date > :now')
            ->andWhere('e.jeu = :game')
            ->setParameter('now', new \DateTime())
            ->setParameter('game', $game)
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
