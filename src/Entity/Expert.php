<?php

namespace App\Entity;

use App\Repository\ExpertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpertRepository::class)
 */
class Expert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="expert", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $connectingStructure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $illustration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $expertiseAreas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interventionZones;

    /**
     * @ORM\OneToMany(targetEntity=ExpertArgumentation::class, mappedBy="depositary")
     */
    private $Argumentations;

    public function __construct()
    {
        $this->Argumentations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getConnectingStructure(): ?string
    {
        return $this->connectingStructure;
    }

    public function setConnectingStructure(string $connectingStructure): self
    {
        $this->connectingStructure = $connectingStructure;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getExpertiseAreas(): ?string
    {
        return $this->expertiseAreas;
    }

    public function setExpertiseAreas(string $expertiseAreas): self
    {
        $this->expertiseAreas = $expertiseAreas;

        return $this;
    }

    public function getInterventionZones(): ?string
    {
        return $this->interventionZones;
    }

    public function setInterventionZones(string $interventionZones): self
    {
        $this->interventionZones = $interventionZones;

        return $this;
    }

    /**
     * @return Collection|ExpertArgumentation[]
     */
    public function getArgumentations(): Collection
    {
        return $this->Argumentations;
    }

    public function addArgumentation(ExpertArgumentation $argumentation): self
    {
        if (!$this->Argumentations->contains($argumentation)) {
            $this->Argumentations[] = $argumentation;
            $argumentation->setDepositary($this);
        }

        return $this;
    }

    public function removeArgumentation(ExpertArgumentation $argumentation): self
    {
        if ($this->Argumentations->contains($argumentation)) {
            $this->Argumentations->removeElement($argumentation);
            // set the owning side to null (unless already changed)
            if ($argumentation->getDepositary() === $this) {
                $argumentation->setDepositary(null);
            }
        }

        return $this;
    }
}
