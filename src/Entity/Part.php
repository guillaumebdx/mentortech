<?php

namespace App\Entity;

use App\Repository\PartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartRepository::class)
 */
class Part
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $exercise;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $solution;

    /**
     * @ORM\ManyToOne(targetEntity=Content::class, inversedBy="parts")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=Screencast::class, mappedBy="part", cascade={"persist"})
     */
    private $screencasts;

    public function __construct()
    {
        $this->screencasts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExercise(): ?string
    {
        return $this->exercise;
    }

    public function setExercise(?string $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getSolution(): ?string
    {
        return $this->solution;
    }

    public function setSolution(?string $solution): self
    {
        $this->solution = $solution;

        return $this;
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
            $screencast->setPart($this);
        }

        return $this;
    }

    public function removeScreencast(Screencast $screencast): self
    {
        if ($this->screencasts->removeElement($screencast)) {
            // set the owning side to null (unless already changed)
            if ($screencast->getPart() === $this) {
                $screencast->setPart(null);
            }
        }

        return $this;
    }
}
