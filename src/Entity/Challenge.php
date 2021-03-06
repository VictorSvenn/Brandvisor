<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 */
class Challenge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Enterprise::class, inversedBy="challenges")
     */
    private $enterprise;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="challenges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConform;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $documents;

    /**
     * @ORM\ManyToOne(targetEntity=Engagement::class, inversedBy="challenges")
     */
    private $engagement;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likes")
     */
    private $likes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $response;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnterprise(): ?Enterprise
    {
        return $this->enterprise;
    }

    public function setEnterprise(?Enterprise $enterprise): self
    {
        $this->enterprise = $enterprise;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIsConform(): ?bool
    {
        return $this->isConform;
    }

    public function setIsConform(bool $isConform): self
    {
        $this->isConform = $isConform;

        return $this;
    }

    public function getDocuments(): ?string
    {
        return $this->documents;
    }

    public function setDocuments(string $documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    public function getEngagement(): ?Engagement
    {
        return $this->engagement;
    }

    public function setEngagement(?Engagement $engagement): self
    {
        $this->engagement = $engagement;
        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
        }

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): self
    {
        $this->response = $response;

        return $this;
    }
}
