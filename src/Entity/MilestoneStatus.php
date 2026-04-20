<?php

namespace App\Entity;

use App\Repository\MilestoneStatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MilestoneStatusRepository::class)]
class MilestoneStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le code est obligatoire.")]
    #[Assert\Length(max: 50, maxMessage: "Le code ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $code = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le libellé est obligatoire.")]
    #[Assert\Length(max: 100, maxMessage: "Le libellé ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
