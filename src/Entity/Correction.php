<?php

namespace App\Entity;

use App\Repository\CorrectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CorrectionRepository::class)
 */
class Correction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=PostedSolution::class, mappedBy="correction")
     */
    private $postedSolution;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="reviews")
     */
    private $reviewer;

    public function __construct()
    {
        $this->postedSolution = new ArrayCollection();
        $this->reviewer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

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
     * @return Collection|PostedSolution[]
     */
    public function getPostedSolution(): Collection
    {
        return $this->postedSolution;
    }

    public function addPostedSolution(PostedSolution $postedSolution): self
    {
        if (!$this->postedSolution->contains($postedSolution)) {
            $this->postedSolution[] = $postedSolution;
            $postedSolution->setCorrection($this);
        }

        return $this;
    }

    public function removePostedSolution(PostedSolution $postedSolution): self
    {
        if ($this->postedSolution->removeElement($postedSolution)) {
            // set the owning side to null (unless already changed)
            if ($postedSolution->getCorrection() === $this) {
                $postedSolution->setCorrection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getReviewer(): Collection
    {
        return $this->reviewer;
    }

    public function addReviewer(User $reviewer): self
    {
        if (!$this->reviewer->contains($reviewer)) {
            $this->reviewer[] = $reviewer;
        }

        return $this;
    }

    public function removeReviewer(User $reviewer): self
    {
        $this->reviewer->removeElement($reviewer);

        return $this;
    }
}
