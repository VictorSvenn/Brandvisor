<?php

namespace App\Entity;

use App\Repository\InitiativeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InitiativeRepository::class)
 */
class Initiative
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="initiatives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $illustration;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\Column(type="text")
     */
    private $objective;

    /**
     * @ORM\Column(type="text")
     */
    private $detailledDescription;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $partner;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $links;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $geographicArea;

    /**
     * @ORM\Column(type="string")
     */
    private $keywords;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isConform;

    /**
     * @ORM\ManyToMany(targetEntity=Odd::class, inversedBy="initiatives")
     */
    private $odd;

    /**
     * @ORM\ManyToMany(targetEntity=Consumer::class, inversedBy="liked")
     */
    private $likes;

    public function __construct()
    {
        $this->odd = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepositary(): ?User
    {
        return $this->depositary;
    }

    public function setDepositary(?User $depositary): self
    {
        $this->depositary = $depositary;

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

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

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

    public function getObjective(): ?string
    {
        return $this->objective;
    }

    public function setObjective(string $objective): self
    {
        $this->objective = $objective;

        return $this;
    }

    public function getDetailledDescription(): ?string
    {
        return $this->detailledDescription;
    }

    public function setDetailledDescription(string $detailledDescription): self
    {
        $this->detailledDescription = $detailledDescription;

        return $this;
    }

    public function getPartner(): ?string
    {
        return $this->partner;
    }

    public function setPartner(?string $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getLinks(): ?string
    {
        return $this->links;
    }

    public function setLinks(?string $links): self
    {
        $this->links = $links;

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

    public function getGeographicArea(): ?string
    {
        return $this->geographicArea;
    }

    public function setGeographicArea(?string $geographicArea): self
    {
        $this->geographicArea = $geographicArea;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getIsConform(): ?bool
    {
        return $this->isConform;
    }

    public function setIsConform(?bool $isConform): self
    {
        $this->isConform = $isConform;

        return $this;
    }

    /**
     * @return Collection|Odd[]
     */
    public function getOdd(): Collection
    {
        return $this->odd;
    }

    public function addOdd(Odd $odd): self
    {
        if (!$this->odd->contains($odd)) {
            $this->odd[] = $odd;
        }

        return $this;
    }

    public function removeOdd(Odd $odd): self
    {
        if ($this->odd->contains($odd)) {
            $this->odd->removeElement($odd);
        }

        return $this;
    }

    /**
     * @return Collection|Consumer[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Consumer $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(Consumer $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
        }

        return $this;
    }
}
