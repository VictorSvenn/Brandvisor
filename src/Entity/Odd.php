<?php

namespace App\Entity;

use App\Repository\OddRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OddRepository::class)
 */
class Odd
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
     * @ORM\ManyToMany(targetEntity=Engagement::class, mappedBy="odd")
     */
    private $engagements;

    /**
     * @ORM\OneToMany(targetEntity=ExpertArgumentation::class, mappedBy="odd")
     */
    private $expertArgumentations;

    /**
     * @ORM\ManyToMany(targetEntity=Initiative::class, mappedBy="odd")
     */
    private $initiatives;

    public function __construct()
    {
        $this->engagements = new ArrayCollection();
        $this->expertArgumentations = new ArrayCollection();
        $this->initiatives = new ArrayCollection();
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
            $engagement->addOdd($this);
        }

        return $this;
    }

    public function removeEngagement(Engagement $engagement): self
    {
        if ($this->engagements->contains($engagement)) {
            $this->engagements->removeElement($engagement);
            $engagement->removeOdd($this);
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
            $expertArgumentation->setOdd($this);
        }

        return $this;
    }

    public function removeExpertArgumentation(ExpertArgumentation $expertArgumentation): self
    {
        if ($this->expertArgumentations->contains($expertArgumentation)) {
            $this->expertArgumentations->removeElement($expertArgumentation);
            // set the owning side to null (unless already changed)
            if ($expertArgumentation->getOdd() === $this) {
                $expertArgumentation->setOdd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Initiative[]
     */
    public function getInitiatives(): Collection
    {
        return $this->initiatives;
    }

    public function addInitiative(Initiative $initiative): self
    {
        if (!$this->initiatives->contains($initiative)) {
            $this->initiatives[] = $initiative;
            $initiative->addOdd($this);
        }

        return $this;
    }

    public function removeInitiative(Initiative $initiative): self
    {
        if ($this->initiatives->contains($initiative)) {
            $this->initiatives->removeElement($initiative);
            $initiative->removeOdd($this);
        }

        return $this;
    }
}
