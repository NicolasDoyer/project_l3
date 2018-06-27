<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PariRepository")
 * @ORM\Table(name="pari")
 */
class Pari
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="paris")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $score_team1;

    /**
     * @ORM\Column(type="integer")
     */
    private $score_team2;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $id_match;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $result;

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getScoreTeam1(): ?int
    {
        return $this->score_team1;
    }

    public function setScoreTeam1(int $score_team1): self
    {
        $this->score_team1 = $score_team1;

        return $this;
    }

    public function getScoreTeam2(): ?int
    {
        return $this->score_team2;
    }

    public function setScoreTeam2(int $score_team2): self
    {
        $this->score_team2 = $score_team2;

        return $this;
    }

    public function getIdMatch(): ?string
    {
        return $this->id_match;
    }

    public function setIdMatch(string $id_match): self
    {
        $this->id_match = $id_match;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(?int $result): self
    {
        $this->result = $result;

        return $this;
    }
}
