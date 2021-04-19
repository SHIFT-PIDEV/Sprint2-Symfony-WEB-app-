<?php

namespace App\Repository;

use App\Entity\Inscrievent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscrievent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscrievent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscrievent[]    findAll()
 * @method Inscrievent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscrieventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscrievent::class);
    }

    // /**
    //  * @return Inscrievent[] Returns an array of Inscrievent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inscrievent
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param $idClient
     * @param $idEvent
     * @return Inscrievent|null
     */
    public function findOneByIdClientIdEvent($idClient,$idEvent):?Inscrievent{
        $em=$this->getEntityManager();
        $query=$em->createQuery('select i from App\Entity\Inscrievent i join i.client c join i.event e
         where c.id= :idclient and e.idevent= :idevent')
            ->setParameter('idclient', $idClient )
        ->setParameter('idevent',$idEvent)
            ->getOneOrNullResult();
        return $query;
    }

    /**
     * @param $idevent
     * @return int|mixed|string
     */
    public function getByIdEvent($idevent){
        $em=$this->getEntityManager();
        return $em->createQuery('select i from App\Entity\Inscrievent i join i.event e
                                where e.idevent= :idevent')
             ->setParameter('idevent',$idevent)
             ->getResult();
    }

    /**
     * @param $idclient
     * @return int|mixed|string
     */
    public function getByIdClient($idclient){
        $em=$this->getEntityManager();
        return $em->createQuery('select i from App\Entity\Inscrievent i join i.client c
                                where c.id= :idclient')
            ->setParameter('idclient',$idclient)
            ->getResult();
    }
}
