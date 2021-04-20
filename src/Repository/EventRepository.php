<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return \Doctrine\ORM\Query
     */
    public function findAllVisible(): \Doctrine\ORM\Query
    {
        $em=$this->getEntityManager();
        return $em->createQuery('select e from App\Entity\Event e ');
    }

    /**
     * @param $data
     * @return \Doctrine\ORM\Query
     */
    public function findByNameOrDesc($data): \Doctrine\ORM\Query
    {
        $em=$this->getEntityManager();
        return $em->createQuery('select s from App\Entity\Event s where s.nomevent LIKE :nomevent')
            ->setParameter('nomevent', '%' . $data . '%');
    }

    /**
     * @param $data
     * @return int|mixed|string
     */
    public function findByNameOrDesc2($data)
    {
        $em=$this->getEntityManager();
        return $em->createQuery('select s from App\Entity\Event s where s.nomevent LIKE :nomevent')
            ->setParameter('nomevent', '%' . $data . '%')
            ->getResult();
    }

    /**
     * @return int|mixed|string
     */
    public function findunvailableEvents(){
        $em=$this->getEntityManager();
        return $em->createQuery('select e from App\Entity\Event e where e.datedebut <= CURRENT_DATE()')
            ->getResult();
    }
    /**
     * @return int|mixed|string
     */
    public function findvailableEvents(){
        $em=$this->getEntityManager();
        return $em->createQuery('select e from App\Entity\Event e where e.datedebut > CURRENT_DATE()')
            ->getResult();
    }

}
