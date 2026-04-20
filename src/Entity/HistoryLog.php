<?php

namespace App\Entity;

use App\Repository\HistoryLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryLogRepository::class)]
#[ORM\Index(columns: ['internship_id', 'created_at'], name: 'idx_history_internship_date')]
#[ORM\Index(columns: ['author_id', 'created_at'], name: 'idx_history_author_date')]
class HistoryLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ActionType $actionType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'historyLogs')]
    private ?Internship $internship = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $oldValue = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $newValue = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionType(): ?ActionType
    {
        return $this->actionType;
    }

    public function setActionType(?ActionType $actionType): static
    {
        $this->actionType = $actionType;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
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

    public function getOldValue(): ?string
    {
        return $this->oldValue;
    }

    public function setOldValue(?string $oldValue): static
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->newValue;
    }

    public function setNewValue(?string $newValue): static
    {
        $this->newValue = $newValue;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
