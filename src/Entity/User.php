<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email",message="Email déjà pris !")
 * @UniqueEntity(fields="username", message="Username déjà pris !")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="users")
     */
    private $team;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default":0})
     */
    private $score = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pari", mappedBy="user", orphanRemoval=true)
     */
    private $paris;

    public function __construct()
    {
        $this->paris = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        $roles= $this->roles;

        if(empty($roles)){
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function serialize()
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    public function unserialize($serialized)
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection|Pari[]
     */
    public function getParis(): Collection
    {
        return $this->paris;
    }

    public function addPari(Pari $pari): self
    {
        if (!$this->paris->contains($pari)) {
            $this->paris[] = $pari;
            $pari->setUser($this);
        }

        return $this;
    }

    public function removePari(Pari $pari): self
    {
        if ($this->paris->contains($pari)) {
            $this->paris->removeElement($pari);
            // set the owning side to null (unless already changed)
            if ($pari->getUser() === $this) {
                $pari->setUser(null);
            }
        }

        return $this;
    }
}
