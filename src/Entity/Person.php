<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity=Island::class, mappedBy="person")
     */
    private $islands;

    public function __construct()
    {
        $this->islands = new ArrayCollection();
    }

    public  function __toString()
    {
        return $this->lastname.' '.$this->firstname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection<int, Island>
     */
    public function getIslands(): Collection
    {
        return $this->islands;
    }

    public function addIsland(Island $island): self
    {
        if (!$this->islands->contains($island)) {
            $this->islands[] = $island;
            $island->setPerson($this);
        }

        return $this;
    }

    public function removeIsland(Island $island): self
    {
        if ($this->islands->removeElement($island)) {
            // set the owning side to null (unless already changed)
            if ($island->getPerson() === $this) {
                $island->setPerson(null);
            }
        }

        return $this;
    }
}
