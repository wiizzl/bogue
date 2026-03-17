<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Controller\Trait\LogsExceptionDetailsTrait;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use App\Service\DeletionCleanupService;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/student')]
#[IsGranted('ROLE_ADMIN')]
final class StudentController extends AbstractController
{
    use CrudControllerTrait;
    use LogsExceptionDetailsTrait;

    public function __construct(private PaginationService $paginationService)
    {
    }

    #[Route(name: 'app_student_index', methods: ['GET'])]
    public function index(Request $request, StudentRepository $studentRepository): Response
    {
        $includeArchived = $request->query->getBoolean('showArchived', false);
        $page = max(1, $request->query->getInt('page', 1));
        $limit = PaginationService::DEFAULT_ITEMS_PER_PAGE;

        try {
            $totalItems = $studentRepository->countForIndex($includeArchived);
            $pagination = $this->paginationService->build($totalItems, $page, $limit);
            $currentPage = $pagination['current_page'];
            $students = $studentRepository->findForIndex($includeArchived, $currentPage, $limit);

            return $this->render('student/index.html.twig', [
                'students' => $students,
                'showArchived' => $includeArchived,
                'current_page' => $pagination['current_page'],
                'pages_count' => $pagination['pages_count'],
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e, 'Student index load failed');
            $this->addFlash('error', 'Erreur lors du chargement des étudiants.');
            return $this->render('student/index.html.twig', [
                'students' => [],
                'showArchived' => $includeArchived,
                'current_page' => 1,
                'pages_count' => 1,
            ]);
        }
    }

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

    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Student $student,
        EntityManagerInterface $entityManager,
        DeletionCleanupService $deletionCleanupService
    ): Response
    {
        $csrfErrorResponse = $this->validateDeleteCsrf($request, $student, 'app_student_index');

        if ($csrfErrorResponse instanceof Response) {
            return $csrfErrorResponse;
        }

        $deletionCleanupService->cleanupStudentDeletion($student, $entityManager);

        return $this->handleDelete($student, $entityManager, 'app_student_index');
    }
}
