<?php

namespace App\Repository;

use App\Entity\Timer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Timer>
 *
 * @method Timer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timer[]    findAll()
 * @method Timer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timer::class);
    }

    public function findRunningTimer($user)
    {
        return $this->createQueryBuilder('t')
            ->where('t.user = :user')
            ->andWhere('t.stoppedAt is NULL')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(Timer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Timer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}