<?php

namespace App\Entity;

use App\Repository\MajorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MajorRepository::class)]
class Major
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Le code est obligatoire.")]
    #[Assert\Length(max: 10, maxMessage: "Le code ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $code = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le libellé est obligatoire.")]
    #[Assert\Length(max: 100, maxMessage: "Le libellé ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $label = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'major')]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setMajor($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($student->getMajor() === $this) {
            throw new \LogicException('Cannot detach student from major because student.major is required. Reassign the student or delete it.');
        }

        $this->students->removeElement($student);

        return $this;
    }
}
