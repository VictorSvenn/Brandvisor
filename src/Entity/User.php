<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Veuillez renseigner votre email.")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Veuillez renseigner votre mot de passe")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner votre prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner votre nom de famille")
     */
    private $lastName;

    /**
     * @ORM\OneToOne(targetEntity=Consumer::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $consumer;

    /**
     * @ORM\OneToOne(targetEntity=Enterprise::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $enterprise;

    /**
     * @ORM\OneToOne(targetEntity=Expert::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $expert;

    /**
     * @ORM\OneToMany(targetEntity=Challenge::class, mappedBy="depositary")
     */
    private $challenges;

    /**
     * @ORM\OneToMany(targetEntity=Initiative::class, mappedBy="depositary")
     */
    private $initiatives;

    /**
     * @ORM\OneToMany(targetEntity=Opinion::class, mappedBy="depositary")
     */
    private $opinions;

    /**
     * @ORM\OneToOne(targetEntity=Admin::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $admin;

    /**
     * @ORM\ManyToMany(targetEntity=Challenge::class, mappedBy="likes")
     */
    private $likes;

    public function __construct()
    {
        $this->challenges = new ArrayCollection();
        $this->initiatives = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getFullName(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getConsumer(): ?Consumer
    {
        return $this->consumer;
    }

    public function setConsumer(Consumer $consumer): self
    {
        $this->consumer = $consumer;

        // set the owning side of the relation if necessary
        if ($consumer->getUser() !== $this) {
            $consumer->setUser($this);
        }

        return $this;
    }

    public function getEnterprise(): ?Enterprise
    {
        return $this->enterprise;
    }

    public function setEnterprise(Enterprise $enterprise): self
    {
        $this->enterprise = $enterprise;

        // set the owning side of the relation if necessary
        if ($enterprise->getUser() !== $this) {
            $enterprise->setUser($this);
        }

        return $this;
    }

    public function getExpert(): ?Expert
    {
        return $this->expert;
    }

    public function setExpert(Expert $expert): self
    {
        $this->expert = $expert;

        // set the owning side of the relation if necessary
        if ($expert->getUser() !== $this) {
            $expert->setUser($this);
        }

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
            $challenge->setDepositary($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->contains($challenge)) {
            $this->challenges->removeElement($challenge);
            // set the owning side to null (unless already changed)
            if ($challenge->getDepositary() === $this) {
                $challenge->setDepositary(null);
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
            $initiative->setDepositary($this);
        }

        return $this;
    }

    public function removeInitiative(Initiative $initiative): self
    {
        if ($this->initiatives->contains($initiative)) {
            $this->initiatives->removeElement($initiative);
            // set the owning side to null (unless already changed)
            if ($initiative->getDepositary() === $this) {
                $initiative->setDepositary(null);
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
            $opinion->setDepositary($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->contains($opinion)) {
            $this->opinions->removeElement($opinion);
            // set the owning side to null (unless already changed)
            if ($opinion->getDepositary() === $this) {
                $opinion->setDepositary(null);
            }
        }

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(Admin $admin): self
    {
        $this->admin = $admin;

        // set the owning side of the relation if necessary
        if ($admin->getUser() !== $this) {
            $admin->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Challenge[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Challenge $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->addLike($this);
        }

        return $this;
    }
}
