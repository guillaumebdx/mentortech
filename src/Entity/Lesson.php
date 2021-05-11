<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Lesson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Program::class, mappedBy="lessons")
     */
    private $programs;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class, inversedBy="lessons")
     */
    private $technologies;

    /**
     * @ORM\OneToOne(targetEntity=Content::class, inversedBy="lesson", cascade={"persist", "remove"})
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=StatusLesson::class, mappedBy="lesson")
     */
    private $statusLessons;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->technologies = new ArrayCollection();
        $this->parts = new ArrayCollection();
        $this->statusLessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->addLesson($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->removeElement($program)) {
            $program->removeLesson($this);
        }

        return $this;
    }

    /**
     * @return Collection|Technology[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

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

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        $this->content = $content;

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
            $statusLesson->setLesson($this);
        }

        return $this;
    }

    public function removeStatusLesson(StatusLesson $statusLesson): self
    {
        if ($this->statusLessons->removeElement($statusLesson)) {
            // set the owning side to null (unless already changed)
            if ($statusLesson->getLesson() === $this) {
                $statusLesson->setLesson(null);
            }
        }

        return $this;
    }

}
