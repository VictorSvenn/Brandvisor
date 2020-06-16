<?php

namespace App\Entity;

use App\Repository\EnterpriseTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnterpriseTypeRepository::class)
 */
class EnterpriseType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EnterpriseCategories::class, inversedBy="types")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Enterprise::class, mappedBy="type")
     */
    private $enterprises;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->enterprises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?EnterpriseCategories
    {
        return $this->category;
    }

    public function setCategory(?EnterpriseCategories $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Enterprise[]
     */
    public function getEnterprises(): Collection
    {
        return $this->enterprises;
    }

    public function addEnterprise(Enterprise $enterprise): self
    {
        if (!$this->enterprises->contains($enterprise)) {
            $this->enterprises[] = $enterprise;
            $enterprise->setType($this);
        }

        return $this;
    }

    public function removeEnterprise(Enterprise $enterprise): self
    {
        if ($this->enterprises->contains($enterprise)) {
            $this->enterprises->removeElement($enterprise);
            // set the owning side to null (unless already changed)
            if ($enterprise->getType() === $this) {
                $enterprise->setType(null);
            }
        }

        return $this;
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
}
