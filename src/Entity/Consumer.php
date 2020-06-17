<?php

namespace App\Entity;

use App\Repository\ConsumerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsumerRepository::class)
 */
class Consumer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="consumer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $geographicArea;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\ManyToMany(targetEntity=Enterprise::class, inversedBy="bookmarked")
     */
    private $bookmarks;

    /**
     * @ORM\ManyToMany(targetEntity=Initiative::class, mappedBy="likes")
     */
    private $liked;

    public function __construct()
    {
        $this->bookmarks = new ArrayCollection();
        $this->liked = new ArrayCollection();
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

    public function getGeographicArea(): ?string
    {
        return $this->geographicArea;
    }

    public function setGeographicArea(string $geographicArea): self
    {
        $this->geographicArea = $geographicArea;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection|Enterprise[]
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Enterprise $bookmark): self
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks[] = $bookmark;
        }

        return $this;
    }

    public function removeBookmark(Enterprise $bookmark): self
    {
        if ($this->bookmarks->contains($bookmark)) {
            $this->bookmarks->removeElement($bookmark);
        }

        return $this;
    }

    /**
     * @return Collection|Initiative[]
     */
    public function getLiked(): Collection
    {
        return $this->liked;
    }

    public function addLiked(Initiative $liked): self
    {
        if (!$this->liked->contains($liked)) {
            $this->liked[] = $liked;
            $liked->addLike($this);
        }

        return $this;
    }

    public function removeLiked(Initiative $liked): self
    {
        if ($this->liked->contains($liked)) {
            $this->liked->removeElement($liked);
            $liked->removeLike($this);
        }

        return $this;
    }
}
