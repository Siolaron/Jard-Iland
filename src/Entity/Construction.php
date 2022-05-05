<?php

namespace App\Entity;

use App\Repository\ConstructionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConstructionRepository::class)
 */
class Construction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre construction doit obligatoirement avoir un nom")
     * @Assert\Length(min=3)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Island::class, inversedBy="constructions")
     */
    private $island;


    public function __construct()
    {

    }

    public function __toString()
    {
        return $this->name;
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

    public function getIsland(): ?Island
    {
        return $this->island;
    }

    public function setIsland(?Island $island): self
    {
        $this->island = $island;

        return $this;
    }

}
