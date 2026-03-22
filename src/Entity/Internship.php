<?php

namespace App\Entity;

use App\Repository\InternshipRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InternshipRepository::class)]
#[ORM\Index(columns: ['tracking_teacher_id', 'visiting_teacher_id'], name: 'idx_internship_teachers')]
#[ORM\Index(columns: ['student_id'], name: 'idx_internship_student')]
#[ORM\Index(columns: ['start_date', 'end_date'], name: 'idx_internship_dates')]
class Internship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'internships')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'internships')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'trackingInternships')]
    private ?User $trackingTeacher = null;

    #[ORM\ManyToOne(inversedBy: 'visitingInternships')]
    private ?User $visitingTeacher = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de début est obligatoire.")]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de fin est obligatoire.")]
    #[Assert\GreaterThan(propertyPath: "startDate", message: "La date de fin doit être après la date de début.")]
    private ?\DateTime $endDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    private ?string $remarks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getTrackingTeacher(): ?User
    {
        return $this->trackingTeacher;
    }

    public function setTrackingTeacher(?User $trackingTeacher): static
    {
        $this->trackingTeacher = $trackingTeacher;

        return $this;
    }

    public function getVisitingTeacher(): ?User
    {
        return $this->visitingTeacher;
    }

    public function setVisitingTeacher(?User $visitingTeacher): static
    {
        $this->visitingTeacher = $visitingTeacher;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDurationInWeeks(): int
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        $diff = $this->startDate->diff($this->endDate);
        $days = $diff->days;

        return (int) ceil($days / 7);
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(?string $remarks): static
    {
        $this->remarks = $remarks;

        return $this;
    }
}
