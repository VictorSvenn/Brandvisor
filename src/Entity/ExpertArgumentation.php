<?php

namespace App\Entity;

use App\Repository\ExpertArgumentationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpertArgumentationRepository::class)
 */
class ExpertArgumentation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Odd::class, inversedBy="expertArgumentations")
     */
    private $odd;

    /**
     * @ORM\ManyToOne(targetEntity=RseCriteria::class, inversedBy="expertArgumentations")
     */
    private $rse;

    /**
     * @ORM\ManyToOne(targetEntity=Expert::class, inversedBy="Argumentations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $depositary;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $illustration;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $links;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $keywords;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOdd(): ?Odd
    {
        return $this->odd;
    }

    public function setOdd(?Odd $odd): self
    {
        $this->odd = $odd;

        return $this;
    }

    public function getRse(): ?RseCriteria
    {
        return $this->rse;
    }

    public function setRse(?RseCriteria $rse): self
    {
        $this->rse = $rse;

        return $this;
    }

    public function getDepositary(): ?Expert
    {
        return $this->depositary;
    }

    public function setDepositary(?Expert $depositary): self
    {
        $this->depositary = $depositary;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

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

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }
}
