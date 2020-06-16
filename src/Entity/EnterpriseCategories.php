<?php

namespace App\Entity;

use App\Repository\EnterpriseCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnterpriseCategoriesRepository::class)
 */
class EnterpriseCategories
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Enterprise::class, mappedBy="category")
     */
    private $enterprises;

    /**
     * @ORM\OneToMany(targetEntity=EnterpriseType::class, mappedBy="category")
     */
    private $types;

    public function __construct()
    {
        $this->enterprises = new ArrayCollection();
        $this->types = new ArrayCollection();
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

    /**
     * @return Collection|EnterpriseType[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(EnterpriseType $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setCategory($this);
        }

        return $this;
    }

    public function removeType(EnterpriseType $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
            // set the owning side to null (unless already changed)
            if ($type->getCategory() === $this) {
                $type->setCategory(null);
            }
        }

        return $this;
    }
}
