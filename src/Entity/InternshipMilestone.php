<?php

namespace App\Entity;

use App\Repository\InternshipMilestoneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InternshipMilestoneRepository::class)]
class InternshipMilestone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'milestones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Internship $internship = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MilestoneStatus $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $validatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Milestone $milestone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInternship(): ?Internship
    {
        return $this->internship;
    }

    public function setInternship(?Internship $internship): static
    {
        $this->internship = $internship;

        return $this;
    }

    public function getStatus(): ?MilestoneStatus
    {
        return $this->status;
    }

    public function setStatus(?MilestoneStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getValidatedAt(): ?\DateTime
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(?\DateTime $validatedAt): static
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getMilestone(): ?Milestone
    {
        return $this->milestone;
    }

    public function setMilestone(?Milestone $milestone): static
    {
        $this->milestone = $milestone;

        return $this;
    }
}
