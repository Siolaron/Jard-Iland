<?php

namespace App\Entity;

use App\Repository\IslandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=IslandRepository::class)
 */
class Island
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre île doit obligatoirement avoir un nom")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Votre île doit obligatoirement avoir une localisation")
     */
    private $localisation;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="islands")
     */
    private $person;

    /**
     * @ORM\OneToMany(targetEntity=Construction::class, mappedBy="island")
     */
    private $constructions;


    public function __toString(){
        return $this->name.' appartient à '.$this->person;
    }

    public function __construct()
    {
        $this->constructions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    /**
     * @return Collection<int, Construction>
     */
    public function getConstructions(): Collection
    {
        return $this->constructions;
    }

    public function addConstruction(Construction $construction): self
    {
        if (!$this->constructions->contains($construction)) {
            $this->constructions[] = $construction;
            $construction->setIsland($this);
        }

        return $this;
    }

    public function removeConstruction(Construction $construction): self
    {
        if ($this->constructions->removeElement($construction)) {
            // set the owning side to null (unless already changed)
            if ($construction->getIsland() === $this) {
                $construction->setIsland(null);
            }
        }

        return $this;
    }

}
