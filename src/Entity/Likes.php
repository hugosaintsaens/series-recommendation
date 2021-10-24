<?php

/**
 * Entité Likes
 * 
 * Cette entité représente la table Likes, étant située entre la table Users et Series
 * 
 * @copyright 2021 BLHL
 */

namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikesRepository::class)
 */
class Likes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $favorite;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $counter;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Series::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $series;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(bool $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    public function getCounter(): ?int
    {
        return $this->counter;
    }

    public function setCounter(?int $counter): self
    {
        $this->counter = $counter;

        return $this;
    }

    public function getUsersId(): ?Users
    {
        return $this->users;
    }

    public function setUsersId(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getSeriesId(): ?Series
    {
        return $this->series;
    }

    public function setSeriesId(?Series $series): self
    {
        $this->series = $series;

        return $this;
    }
}
