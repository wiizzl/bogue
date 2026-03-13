<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controller for managing Student entities.
 *
 * Provides CRUD operations for student management with proper authorization.
 * Uses CrudControllerTrait to reduce code duplication and standardize operations.
 */
#[Route('/student')]
#[IsGranted('ROLE_ADMIN')]
final class StudentController extends AbstractController
{
    use CrudControllerTrait;

    /**
     * List all students with pagination support.
     */
    #[Route(name: 'app_student_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        try {
            $students = $studentRepository->findAll();

            return $this->render('student/index.html.twig', [
                'students' => $students,
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du chargement des étudiants.');
            return $this->render('student/index.html.twig', ['students' => []]);
        }
    }

    /**
     * Display a specific student's details.
     */
    #[Route('/{id}', name: 'app_student_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * Create a new student.
     */
    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        return $this->handleCreate(
            $request,
            $student,
            $form,
            $entityManager,
            'student/new.html.twig',
            'app_student_index'
        );
    }

    /**
     * Edit an existing student.
     */
    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentType::class, $student);

        return $this->handleUpdate(
            $request,
            $student,
            $form,
            $entityManager,
            'student/edit.html.twig',
            'app_student_index'
        );
    }

    /**
     * Delete a student using form-based CSRF protection.
     *
     * Replaced manual CSRF token validation with proper form handling.
     */
    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$student->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Token de sécurité invalide.');
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->handleDelete($student, $entityManager, 'app_student_index');
    }

    /**
     * Override entity display name for flash messages.
     */
    protected function getEntityDisplayName(object $entity): string
    {
        return 'Étudiant';
    }
}
