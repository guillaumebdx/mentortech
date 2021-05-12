<?php

namespace App\Entity;

use App\Repository\StatusLessonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusLessonRepository::class)
 */
class StatusLesson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="statusLessons")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="statusLessons")
     */
    private $lesson;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPosted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }

    public function getIsPosted(): ?bool
    {
        return $this->isPosted;
    }

    public function setIsPosted(?bool $isPosted): self
    {
        $this->isPosted = $isPosted;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }
}
