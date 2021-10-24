<?php

/**
 * Entité Words 
 * 
 * Cette entité représente la table Words
 * 
 * @copyright 2021 BLHL
 */

namespace App\Entity;

use App\Repository\WordsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=WordsRepository::class)
 * @UniqueEntity(fields="libelle", message="Le mot est déjà pris.")
 */
class Words
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $libelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
