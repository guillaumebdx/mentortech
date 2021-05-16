<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $credit = 10;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $githubName;

    /**
     * @ORM\OneToMany(targetEntity=Attribution::class, mappedBy="user")
     */
    private $attributions;

    /**
     * @ORM\OneToMany(targetEntity=StatusLesson::class, mappedBy="user")
     */
    private $statusLessons;

    /**
     * @ORM\OneToMany(targetEntity=PostedSolution::class, mappedBy="user")
     */
    private $postedSolutions;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->attributions = new ArrayCollection();
        $this->statusLessons = new ArrayCollection();
        $this->postedSolutions = new ArrayCollection();
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
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getGithubName(): ?string
    {
        return $this->githubName;
    }

    public function setGithubName(?string $githubName): self
    {
        $this->githubName = $githubName;

        return $this;
    }

    /**
     * @return Collection|Attribution[]
     */
    public function getAttributions(): Collection
    {
        return $this->attributions;
    }

    public function addAttribution(Attribution $attribution): self
    {
        if (!$this->attributions->contains($attribution)) {
            $this->attributions[] = $attribution;
            $attribution->setUser($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): self
    {
        if ($this->attributions->removeElement($attribution)) {
            // set the owning side to null (unless already changed)
            if ($attribution->getUser() === $this) {
                $attribution->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatusLesson[]
     */
    public function getStatusLessons(): Collection
    {
        return $this->statusLessons;
    }

    public function addStatusLesson(StatusLesson $statusLesson): self
    {
        if (!$this->statusLessons->contains($statusLesson)) {
            $this->statusLessons[] = $statusLesson;
            $statusLesson->setUser($this);
        }

        return $this;
    }

    public function removeStatusLesson(StatusLesson $statusLesson): self
    {
        if ($this->statusLessons->removeElement($statusLesson)) {
            // set the owning side to null (unless already changed)
            if ($statusLesson->getUser() === $this) {
                $statusLesson->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PostedSolution[]
     */
    public function getPostedSolutions(): Collection
    {
        return $this->postedSolutions;
    }

    public function addPostedSolution(PostedSolution $postedSolution): self
    {
        if (!$this->postedSolutions->contains($postedSolution)) {
            $this->postedSolutions[] = $postedSolution;
            $postedSolution->setUser($this);
        }

        return $this;
    }

    public function removePostedSolution(PostedSolution $postedSolution): self
    {
        if ($this->postedSolutions->removeElement($postedSolution)) {
            // set the owning side to null (unless already changed)
            if ($postedSolution->getUser() === $this) {
                $postedSolution->setUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Gets triggered only on insert
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
