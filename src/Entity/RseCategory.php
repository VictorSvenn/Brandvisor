<?php

namespace App\Entity;

use App\Repository\RseCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RseCategoryRepository::class)
 */
class RseCategory
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
     * @ORM\OneToMany(targetEntity=RseCriteria::class, mappedBy="category")
     */
    private $rseCriterias;

    public function __construct()
    {
        $this->rseCriterias = new ArrayCollection();
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
     * @return Collection|RseCriteria[]
     */
    public function getRseCriterias(): Collection
    {
        return $this->rseCriterias;
    }

    public function addRseCriteria(RseCriteria $rseCriteria): self
    {
        if (!$this->rseCriterias->contains($rseCriteria)) {
            $this->rseCriterias[] = $rseCriteria;
            $rseCriteria->setCategory($this);
        }

        return $this;
    }

    public function removeRseCriteria(RseCriteria $rseCriteria): self
    {
        if ($this->rseCriterias->contains($rseCriteria)) {
            $this->rseCriterias->removeElement($rseCriteria);
            // set the owning side to null (unless already changed)
            if ($rseCriteria->getCategory() === $this) {
                $rseCriteria->setCategory(null);
            }
        }

        return $this;
    }
}
