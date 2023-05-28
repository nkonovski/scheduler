<?php

namespace App\Entity;

use App\Repository\TimerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimerRepository::class)]
class Timer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[OneToMany(targetEntity: Project::class, inversedBy: 'timers')]
    #[JoinColumn(nullable: true)]
    private ?string $project = null;

    #[OneToMany(targetEntity: User::class, inversedBy: 'timers')]
    #[JoinColumn(nullable: true)]
    private ?string $user = null;

    #[ORM\Column]
    private ?\DateTime $startedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $stopedAt = null;

    #[ORM\Column]
    private ?\DateTime $created = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updated = null;

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

    public function getProject(): ?string
    {
        return $this->project;
    }

    public function setProject(string $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getStopedAt(): ?\DateTimeImmutable
    {
        return $this->stopedAt;
    }

    public function setStopedAt(?\DateTimeImmutable $stopedAt): self
    {
        $this->stopedAt = $stopedAt;

        return $this;
    }

    public function getCreated(): ?string
    {
        return $this->created;
    }

    public function setCreated(string $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?string
    {
        return $this->updated;
    }

    public function setUpdated(?string $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
