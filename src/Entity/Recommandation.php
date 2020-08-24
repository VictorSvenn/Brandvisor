<?php

namespace App\Entity;

use App\Repository\RecommandationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecommandationRepository::class)
 */
class Recommandation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $firstLink;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $secondLink;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $thirdLink;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fourthLink;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $firstImage;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $secondImage;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $thirdImage;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $fourthImage;

    /**
     * @ORM\OneToOne(targetEntity=Enterprise::class, mappedBy="recommandation")
     * @ORM\JoinColumn(nullable=true)
     */
    private $enterprise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstLink(): ?string
    {
        return $this->firstLink;
    }

    public function setFirstLink(?string $firstLink): self
    {
        $this->firstLink = $firstLink;

        return $this;
    }

    public function getSecondLink(): ?string
    {
        return $this->secondLink;
    }

    public function setSecondLink(?string $secondLink): self
    {
        $this->secondLink = $secondLink;

        return $this;
    }

    public function getThirdLink(): ?string
    {
        return $this->thirdLink;
    }

    public function setThirdLink(?string $thirdLink): self
    {
        $this->thirdLink = $thirdLink;

        return $this;
    }

    public function getFourthLink(): ?string
    {
        return $this->fourthLink;
    }

    public function setFourthLink(?string $fourthLink): self
    {
        $this->fourthLink = $fourthLink;

        return $this;
    }

    public function getFirstImage(): ?string
    {
        return $this->firstImage;
    }

    public function setFirstImage(?string $firstImage): self
    {
        $this->firstImage = $firstImage;

        return $this;
    }

    public function getSecondImage(): ?string
    {
        return $this->secondImage;
    }

    public function setSecondImage(?string $secondImage): self
    {
        $this->secondImage = $secondImage;

        return $this;
    }

    public function getThirdImage(): ?string
    {
        return $this->thirdImage;
    }

    public function setThirdImage(?string $thirdImage): self
    {
        $this->thirdImage = $thirdImage;

        return $this;
    }

    public function getFourthImage(): ?string
    {
        return $this->fourthImage;
    }

    public function setFourthImage(?string $fourthImage): self
    {
        $this->fourthImage = $fourthImage;

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
}
