<?php

/**
 * Répertoire Likes
 * 
 * Ce répertoire englobe les requêtes d'interrogation SQL ciblant la table Likes
 * 
 * @copyright 2021 BLHL
 */

namespace App\Repository;

use PDO;
use App\Entity\Likes;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Likes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Likes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Likes[]    findAll()
 * @method Likes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Likes::class);
    }

    /**
     * Retourne les séries et les likes
     * 
     * @param int $limit nombre de séries à afficher par page
     * @param int $offset spécifie les tuples qui doivent être renvoyés
     * @param int $id id de l'utilisateur connecté
     * 
     * @author BLHL
     * @return array[]
     */
    public function findPaginatedSeriesAndLikes($limit, $offset, $id)
    {
        return $this->createQueryBuilder('l')
            ->select('s.id as series_id, s.name as series_name, l.favorite as likes_favorite, l.id as likes_id')
            ->from('App\Entity\Series', 's')
            ->where('l.series = s.id')
            ->andWhere('l.users = :id')
            ->setParameter(':id', $id)
            ->orderBy('l.favorite', 'ASC')
            ->addOrderBy('s.name', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les séries contenant le ou les mot(s)-clé(s) saisi(s) par l'utilisateur et les likes
     * 
     * @param array[] $words mot(s) tapé(s) par l'utilisateur
     * @param int $limit nombre de séries à afficher par page
     * @param int $offset spécifie les tuples qui doivent être renvoyés
     * @param int $id id de l'utilisateur connecté
     * 
     * @author BLHL
     * @return array[] $stmt
     */
    public function findPaginatedSeriesAndLikesByWords($words, $limit, $offset, $id)
    {
        return $this->createQueryBuilder('l')
            ->select('s.id as series_id, s.name as series_name, l.favorite as likes_favorite, l.id as likes_id')
            ->from('App\Entity\Contains', 'c')
            ->from('App\Entity\Series', 's')
            ->from('App\Entity\Words', 'w')
            ->where('l.series = s.id')
            ->andWhere('c.series = s.id')
            ->andWhere('c.words = w.id')
            ->andWhere('l.users = :id')
            ->setParameter('id', $id)
            ->andWhere('w.libelle IN (:words)')
            ->setParameter('words', array_values($words))
            ->groupBy('s.id')
            ->having('COUNT(s.id) = :nbrWords')
            ->setParameter(':nbrWords', count($words))
            ->orderBy('l.favorite', 'ASC')
            ->addOrderBy('c.appearance', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
