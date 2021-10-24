<?php

/**
 * Entité Contains 
 * 
 * Cette entité représente la table Contains, étant située entre la table Series et Words
 * 
 * @copyright 2021 BLHL
 */

namespace App\Entity;

use App\Repository\ContainsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContainsRepository::class)
 */
class Contains
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $appearance;

    /**
     * @ORM\ManyToOne(targetEntity=Series::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $series;

    /**
     * @ORM\ManyToOne(targetEntity=Words::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $words;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppearance(): ?float
    {
        return $this->appearance;
    }

    public function setAppearance(float $appearance): self
    {
        $this->appearance = $appearance;

        return $this;
    }

    public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setSeries(?Series $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getWords(): ?Words
    {
        return $this->words;
    }

    public function setWords(?Words $words): self
    {
        $this->words = $words;

        return $this;
    }
}
