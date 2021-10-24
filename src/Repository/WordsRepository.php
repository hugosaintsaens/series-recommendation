<?php

/**
 * Répertoire Words
 * 
 * Ce répertoire englobe les requêtes d'interrogation SQL ciblant la table Words
 * 
 * @copyright 2021 BLHL
 */

namespace App\Repository;

use App\Entity\Words;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Words|null find($id, $lockMode = null, $lockVersion = null)
 * @method Words|null findOneBy(array $criteria, array $orderBy = null)
 * @method Words[]    findAll()
 * @method Words[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Words::class);
    }
}
