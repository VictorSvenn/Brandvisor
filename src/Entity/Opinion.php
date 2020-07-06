<?php

namespace App\Entity;

use App\Repository\OpinionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpinionRepository::class)
 */
class Opinion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="opinions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositary;

    /**
     * @ORM\ManyToOne(targetEntity=Enterprise::class, inversedBy="opinions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enterprise;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isConform;

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

    public function getEnterprise(): ?Enterprise
    {
        return $this->enterprise;
    }

    public function setEnterprise(?Enterprise $enterprise): self
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function __construct()
    {
        $this->isConform = false;
    }
}
