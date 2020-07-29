<?php

namespace App\Entity;

use App\Repository\EngagementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EngagementRepository::class)
 */
class Engagement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Enterprise::class, inversedBy="engagements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $actionText;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $actionDocuments = [];

    /**
     * @ORM\Column(type="text")
     */
    private $resultsText;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $resultsDocuments = [];

    /**
     * @ORM\Column(type="text")
     */
    private $benefits;

    /**
     * @ORM\Column(type="text")
     */
    private $proofText;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $proofDocuments = [];

    /**
     * @ORM\OneToMany(targetEntity=Challenge::class, mappedBy="engagement")
     */
    private $challenges;

    /**
     * @ORM\ManyToMany(targetEntity=Odd::class, inversedBy="engagements")
     */
    private $odd;

    /**
     * @ORM\ManyToMany(targetEntity=RseCriteria::class, inversedBy="engagements")
     */
    private $rse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isConform = 0;

    public function __construct()
    {
        $this->challenges = new ArrayCollection();
        $this->odd = new ArrayCollection();
        $this->rse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?Enterprise
    {
        return $this->owner;
    }

    public function setOwner(?Enterprise $owner): self
    {
        $this->owner = $owner;

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

    public function getActionText(): ?string
    {
        return $this->actionText;
    }

    public function setActionText(string $actionText): self
    {
        $this->actionText = $actionText;

        return $this;
    }

    public function getActionDocuments(): ?array
    {
        return $this->actionDocuments;
    }

    public function setActionDocuments(?array $actionDocuments): self
    {
        $this->actionDocuments = $actionDocuments;

        return $this;
    }

    public function getResultsText(): ?string
    {
        return $this->resultsText;
    }

    public function setResultsText(string $resultsText): self
    {
        $this->resultsText = $resultsText;

        return $this;
    }

    public function getResultsDocuments(): ?array
    {
        return $this->resultsDocuments;
    }

    public function setResultsDocuments(?array $resultsDocuments): self
    {
        $this->resultsDocuments = $resultsDocuments;

        return $this;
    }

    public function getBenefits(): ?string
    {
        return $this->benefits;
    }

    public function setBenefits(string $benefits): self
    {
        $this->benefits = $benefits;

        return $this;
    }

    public function getProofText(): ?string
    {
        return $this->proofText;
    }

    public function setProofText(string $proofText): self
    {
        $this->proofText = $proofText;

        return $this;
    }

    public function getProofDocuments(): ?array
    {
        return $this->proofDocuments;
    }

    public function setProofDocuments(?array $proofDocuments): self
    {
        $this->proofDocuments = $proofDocuments;

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
     * @return Collection|Challenge[]
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->setEngagement($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->contains($challenge)) {
            $this->challenges->removeElement($challenge);
            // set the owning side to null (unless already changed)
            if ($challenge->getEngagement() === $this) {
                $challenge->setEngagement(null);
            }
        }

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
     * @return Collection|RseCriteria[]
     */
    public function getRse(): Collection
    {
        return $this->rse;
    }

    public function addRse(RseCriteria $rse): self
    {
        if (!$this->rse->contains($rse)) {
            $this->rse[] = $rse;
        }

        return $this;
    }

    public function removeRse(RseCriteria $rse): self
    {
        if ($this->rse->contains($rse)) {
            $this->rse->removeElement($rse);
        }

        return $this;
    }
}
