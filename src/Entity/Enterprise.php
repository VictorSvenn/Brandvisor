<?php

namespace App\Entity;

use App\Repository\EnterpriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * @SuppressWarnings(PHPMD)
 * @ORM\Entity(repositoryClass=EnterpriseRepository::class)
 */
class Enterprise
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactFunction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="integer")
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enterprisePhone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $enterprisePres;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $documents = [];

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="enterprise", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Challenge::class, mappedBy="enterprise")
     */
    private $challenges;

    /**
     * @ORM\ManyToMany(targetEntity=Consumer::class, mappedBy="bookmarks")
     */
    private $bookmarked;

    /**
     * @ORM\OneToMany(targetEntity=Engagement::class, mappedBy="owner")
     */
    private $engagements;

    /**
     * @ORM\OneToMany(targetEntity=Opinion::class, mappedBy="enterprise")
     */
    private $opinions;

    /**
     * @ORM\ManyToOne(targetEntity=EnterpriseType::class, inversedBy="enterprises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid = false;

    public function __construct()
    {
        $this->challenges = new ArrayCollection();
        $this->bookmarked = new ArrayCollection();
        $this->engagements = new ArrayCollection();
        $this->opinions = new ArrayCollection();
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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

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

    public function getContactFunction(): ?string
    {
        return $this->contactFunction;
    }

    public function setContactFunction(string $contactFunction): self
    {
        $this->contactFunction = $contactFunction;

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

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getEnterprisePhone(): ?string
    {
        return $this->enterprisePhone;
    }

    public function setEnterprisePhone(string $enterprisePhone): self
    {
        $this->enterprisePhone = $enterprisePhone;

        return $this;
    }

    public function getEnterprisePres(): ?string
    {
        return $this->enterprisePres;
    }

    public function setEnterprisePres(string $enterprisePres): self
    {
        $this->enterprisePres = $enterprisePres;

        return $this;
    }

    public function getDocuments(): ?array
    {
        return $this->documents;
    }

    public function setDocuments(array $documents): self
    {
        $this->documents = $documents;

        return $this;
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
            $challenge->setEnterprise($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->contains($challenge)) {
            $this->challenges->removeElement($challenge);
            // set the owning side to null (unless already changed)
            if ($challenge->getEnterprise() === $this) {
                $challenge->setEnterprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Consumer[]
     */
    public function getBookmarked(): Collection
    {
        return $this->bookmarked;
    }

    public function addBookmarked(Consumer $bookmarked): self
    {
        if (!$this->bookmarked->contains($bookmarked)) {
            $this->bookmarked[] = $bookmarked;
            $bookmarked->addBookmark($this);
        }

        return $this;
    }

    public function removeBookmarked(Consumer $bookmarked): self
    {
        if ($this->bookmarked->contains($bookmarked)) {
            $this->bookmarked->removeElement($bookmarked);
            $bookmarked->removeBookmark($this);
        }

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
            $engagement->setOwner($this);
        }

        return $this;
    }

    public function removeEngagement(Engagement $engagement): self
    {
        if ($this->engagements->contains($engagement)) {
            $this->engagements->removeElement($engagement);
            // set the owning side to null (unless already changed)
            if ($engagement->getOwner() === $this) {
                $engagement->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setEnterprise($this);
        }

        return $this;
    }


    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->contains($opinion)) {
            $this->opinions->removeElement($opinion);
            // set the owning side to null (unless already changed)
            if ($opinion->getEnterprise() === $this) {
                $opinion->setEnterprise(null);
            }
        }

        return $this;
    }

    public function getType(): ?EnterpriseType
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }
}
