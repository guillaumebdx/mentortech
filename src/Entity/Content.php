<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\OneToMany(targetEntity=Screencast::class, mappedBy="content")
     */
    private $screencasts;

    /**
     * @ORM\OneToMany(targetEntity=Part::class, mappedBy="content")
     */
    private $parts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $finalExercise;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $finalSolution;

    public function __construct()
    {
        $this->screencasts = new ArrayCollection();
        $this->parts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * @return Collection|Screencast[]
     */
    public function getScreencasts(): Collection
    {
        return $this->screencasts;
    }

    public function addScreencast(Screencast $screencast): self
    {
        if (!$this->screencasts->contains($screencast)) {
            $this->screencasts[] = $screencast;
            $screencast->setContent($this);
        }

        return $this;
    }

    public function removeScreencast(Screencast $screencast): self
    {
        if ($this->screencasts->removeElement($screencast)) {
            // set the owning side to null (unless already changed)
            if ($screencast->getContent() === $this) {
                $screencast->setContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Part[]
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(Part $part): self
    {
        if (!$this->parts->contains($part)) {
            $this->parts[] = $part;
            $part->setContent($this);
        }

        return $this;
    }

    public function removePart(Part $part): self
    {
        if ($this->parts->removeElement($part)) {
            // set the owning side to null (unless already changed)
            if ($part->getContent() === $this) {
                $part->setContent(null);
            }
        }

        return $this;
    }

    public function getFinalExercise(): ?string
    {
        return $this->finalExercise;
    }

    public function setFinalExercise(?string $finalExercise): self
    {
        $this->finalExercise = $finalExercise;

        return $this;
    }

    public function getFinalSolution(): ?string
    {
        return $this->finalSolution;
    }

    public function setFinalSolution(?string $finalSolution): self
    {
        $this->finalSolution = $finalSolution;

        return $this;
    }
}
