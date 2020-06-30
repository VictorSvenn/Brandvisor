<?php

namespace App\Entity;

use App\Repository\RseCriteriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RseCriteriaRepository::class)
 */
class RseCriteria
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RseCategory::class, inversedBy="rseCriterias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Engagement::class, mappedBy="rse")
     */
    private $engagements;

    /**
     * @ORM\OneToMany(targetEntity=ExpertArgumentation::class, mappedBy="rse")
     */
    private $expertArgumentations;

    public function __construct()
    {
        $this->engagements = new ArrayCollection();
        $this->expertArgumentations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?RseCategory
    {
        return $this->category;
    }

    public function setCategory(?RseCategory $category): self
    {
        $this->category = $category;

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

    /**
     * @return Collection|Engagement[]
     */
    public function getEngagements(): Collection
    {
        return $this->engagements;
    }

    public function addEngagement(Engagement $engagement): self
    {
        if (!$this->engagements->contains($engagement)) {
            $this->engagements[] = $engagement;
            $engagement->addRse($this);
        }

        return $this;
    }

    public function removeEngagement(Engagement $engagement): self
    {
        if ($this->engagements->contains($engagement)) {
            $this->engagements->removeElement($engagement);
            $engagement->removeRse($this);
        }

        return $this;
    }

    /**
     * @return Collection|ExpertArgumentation[]
     */
    public function getExpertArgumentations(): Collection
    {
        return $this->expertArgumentations;
    }

    public function addExpertArgumentation(ExpertArgumentation $expertArgumentation): self
    {
        if (!$this->expertArgumentations->contains($expertArgumentation)) {
            $this->expertArgumentations[] = $expertArgumentation;
            $expertArgumentation->setRse($this);
        }

        return $this;
    }

    public function removeExpertArgumentation(ExpertArgumentation $expertArgumentation): self
    {
        if ($this->expertArgumentations->contains($expertArgumentation)) {
            $this->expertArgumentations->removeElement($expertArgumentation);
            // set the owning side to null (unless already changed)
            if ($expertArgumentation->getRse() === $this) {
                $expertArgumentation->setRse(null);
            }
        }

        return $this;
    }
}
