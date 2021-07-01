<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Michelf\MarkdownExtra;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\OneToMany(targetEntity=Part::class, mappedBy="content", cascade="remove")
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

    /**
     * @ORM\OneToOne(targetEntity=Lesson::class, mappedBy="content", cascade={"persist", "remove"})
     */
    private $lesson;

    public function __construct()
    {
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

    public function getIntroductionMd(): ?string
    {
        return MarkdownExtra::defaultTransform($this->introduction);
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

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

    public function getFinalExerciseMd(): ?string
    {
        return MarkdownExtra::defaultTransform($this->finalExercise);
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

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        // unset the owning side of the relation if necessary
        if ($lesson === null && $this->lesson !== null) {
            $this->lesson->setContent(null);
        }

        // set the owning side of the relation if necessary
        if ($lesson !== null && $lesson->getContent() !== $this) {
            $lesson->setContent($this);
        }

        $this->lesson = $lesson;

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
