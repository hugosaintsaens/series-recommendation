<?php

/**
 * Répertoire Series
 * 
 * Ce répertoire englobe les requêtes d'interrogation SQL ciblant la table Series
 * 
 * @copyright 2021 BLHL
 */

namespace App\Repository;

use App\Entity\Series;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Series|null find($id, $lockMode = null, $lockVersion = null)
 * @method Series|null findOneBy(array $criteria, array $orderBy = null)
 * @method Series[]    findAll()
 * @method Series[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Series::class);
    }

    /**
     * Retourne le nombre total de séries
     * 
     * @author BLHL
     * @return int
     */
    public function findTotalSeries()
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Retourne les séries
     * 
     * @param int $limit nombre de séries à afficher par page
     * @param int $offset spécifie les tuples qui doivent être renvoyés
     * 
     * @author BLHL
     * @return array[]
     */
    public function findPaginatedSeries($limit, $offset)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id as series_id, s.name as series_name')
            ->orderBy('s.name', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
