<?php

/**
 * Répertoire Contains
 * 
 * Ce répertoire englobe les requêtes d'interrogation SQL ciblant la table Contains
 * 
 * @copyright 2021 BLHL
 */

namespace App\Repository;

use PDO;
use App\Entity\Contains;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Contains|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contains|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contains[]    findAll()
 * @method Contains[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContainsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contains::class);
    }

    /**
     * Retourne le nombre total de série en fonction d'un ou plusieurs mot(s)-clé(s) saisi(s) par l'utilisateur
     * 
     * @param array[] $words mot(s) tapé(s) par l'utilisateur
     * 
     * @author BLHL
     * @return array[]
     */
    public function findTotalSeriesByWords($words)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(s.id)')
            ->from('App\Entity\Series', 's')
            ->from('App\Entity\Words', 'w')
            ->where('c.series = s.id')
            ->andWhere('c.words = w.id')
            ->andWhere('w.libelle IN(:words)')
            ->setParameter('words', array_values($words))
            ->groupBy('s.id')
            ->having('COUNT(s.id) = :nbrWords')
            ->setParameter(':nbrWords', count($words))
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les séries contenant le ou les mot(s)-clé(s) saisi(s) par l'utilisateur
     * 
     * @param array[] $words mot(s) tapé(s) par l'utilisateur
     * @param int $limit nombre de séries à afficher par page
     * @param int $offset spécifie les tuples qui doivent être renvoyés
     * 
     * @author BLHL
     * @return array[]
     */
    public function findPaginatedSeriesByWords($words, $limit, $offset)
    {
        return $this->createQueryBuilder('c')
            ->select('s.id as series_id, s.name as series_name')
            ->from('App\Entity\Series', 's')
            ->from('App\Entity\Words', 'w')
            ->where('c.series = s.id')
            ->andWhere('c.words = w.id')
            ->andWhere('w.libelle IN (:words)')
            ->setParameter('words', array_values($words))
            ->groupBy('s.id')
            ->having('COUNT(s.id) = :nbrWords')
            ->setParameter(':nbrWords', count($words))
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('c.appearance', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne le top mots-clés de la série en paramètre
     * 
     * @param int $id id de la série
     * 
     * @author BLHL
     * @return array[]
     */
    public function findTopWords($id)
    {
        return $this->createQueryBuilder('c')
            ->select('w.libelle')
            ->from('App\Entity\Words', 'w')
            ->from('App\Entity\Series', 's')
            ->where('c.words = w.id')
            ->andWhere('c.series = s.id')
            ->andWhere('s.id = :id')
            ->setParameter(':id', $id)
            ->orderBy('c.appearance', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les séries similaires de la série en paramètre
     * 
     * @param int $id id de la série
     * 
     * @author BLHL
     * @return array[]
     */
    public function findSimilarSeries($id)
    {
        $subquery = $this->createQueryBuilder('c')
            ->select('w.id')
            ->from('App\Entity\Words', 'w')
            ->where('c.words = w.id')
            ->andWhere('c.series = :id')
            ->setParameter(':id', $id)
            ->orderBy('c.appearance', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $this->createQueryBuilder('c')
            ->select('s.id, s.name')
            ->from('App\Entity\Words', 'w')
            ->from('App\Entity\Series', 's')
            ->where('c.series = s.id')
            ->andWhere('c.words = w.id')
            ->andWhere('s.id NOT IN (:id)')
            ->setParameter(':id', $id)
            ->andWhere('w.id = :words_id')
            ->setParameter(':words_id', array_values($subquery))
            ->orderBy('c.appearance', 'DESC')
            ->addOrderBy('s.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
