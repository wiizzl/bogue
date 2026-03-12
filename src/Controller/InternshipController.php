<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Entity\Internship;
use App\Entity\InternshipMilestone;
use App\Form\InternshipType;
use App\Repository\InternshipRepository;
use App\Repository\MilestoneRepository;
use App\Repository\MilestoneStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controller for managing Internship entities.
 *
 * Provides CRUD operations with role-based and resource-based access control.
 * Uses voters to ensure teachers can only access their assigned internships.
 */
#[Route('/internship')]
#[IsGranted('ROLE_TEACHER')] // Teachers can access, but voters control specific actions
final class InternshipController extends AbstractController
{
    use CrudControllerTrait;

    /**
     * List internships based on user permissions.
     *
     * ADMIN/SECRETARY: see all internships
     * TEACHER: redirected to home page (filtered view)
     */
    #[Route(name: 'app_internship_index', methods: ['GET'])]
    #[IsGranted('ROLE_SECRETARY')] // Only admin/secretary can see full list
    public function index(InternshipRepository $internshipRepository): Response
    {
        try {
            return $this->render('internship/index.html.twig', [
                'internships' => $internshipRepository->findAll(),
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du chargement des stages : ' . $e->getMessage());
            return $this->render('internship/index.html.twig', ['internships' => []]);
        }
    }

    /**
     * Create a new internship with automatic milestone initialization.
     *
     * Automatically creates all milestones with PENDING status for the new internship.
     */
    #[Route('/new', name: 'app_internship_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')] // Only admins can create internships
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        MilestoneRepository $milestoneRepo,
        MilestoneStatusRepository $statusRepo
    ): Response {
        $internship = new Internship();
        $form = $this->createForm(InternshipType::class, $internship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Start transaction for consistency
                $entityManager->beginTransaction();

                $entityManager->persist($internship);

                // Initialize all milestones with PENDING status
                $this->initializeInternshipMilestones($internship, $milestoneRepo, $statusRepo, $entityManager);

                $entityManager->flush();
                $entityManager->commit();

                $this->addFlash('success', 'Stage créé avec succès et jalons initialisés.');
                return $this->redirectToRoute('app_internship_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $entityManager->rollback();
                $this->addFlash('error', 'Erreur lors de la création du stage : ' . $e->getMessage());
            }
        }

        return $this->render('internship/new.html.twig', [
            'internship' => $internship,
            'form' => $form,
        ]);
    }

    /**
     * Display internship details with access control.
     *
     * Uses voter to ensure teachers can only view their assigned internships.
     */
    #[Route('/{id}', name: 'app_internship_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Internship $internship): Response
    {
        // Use voter to check VIEW permission
        if (!$this->isGranted('VIEW_INTERNSHIP', $internship)) {
            return $this->handleAccessDenied('consulter', $internship);
        }

        return $this->render('internship/show.html.twig', [
            'internship' => $internship,
        ]);
    }

    /**
     * Edit internship with proper access control.
     */
    #[Route('/{id}/edit', name: 'app_internship_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Internship $internship, EntityManagerInterface $entityManager): Response
    {
        // Use voter to check EDIT permission
        if (!$this->isGranted('EDIT_INTERNSHIP', $internship)) {
            return $this->handleAccessDenied('modifier', $internship);
        }

        $form = $this->createForm(InternshipType::class, $internship);

        return $this->handleUpdate(
            $request,
            $internship,
            $form,
            $entityManager,
            'internship/edit.html.twig',
            'app_internship_index'
        );
    }

    /**
     * Delete internship with access control and form-based CSRF.
     */
    #[Route('/{id}', name: 'app_internship_delete', methods: ['POST'])]
    public function delete(Request $request, Internship $internship, EntityManagerInterface $entityManager): Response
    {
        // Only admins can delete internships
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->handleAccessDenied('supprimer', $internship);
        }

        if (!$this->isCsrfTokenValid('delete'.$internship->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Token de sécurité invalide.');
            return $this->redirectToRoute('app_internship_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->handleDelete($internship, $entityManager, 'app_internship_index');
    }

    /**
     * Initialize all milestones for a new internship with PENDING status.
     *
     * @param Internship $internship
     * @param MilestoneRepository $milestoneRepo
     * @param MilestoneStatusRepository $statusRepo
     * @param EntityManagerInterface $entityManager
     */
    private function initializeInternshipMilestones(
        Internship $internship,
        MilestoneRepository $milestoneRepo,
        MilestoneStatusRepository $statusRepo,
        EntityManagerInterface $entityManager
    ): void {
        $pendingStatus = $statusRepo->findOneBy(['code' => 'PENDING']);

        if (!$pendingStatus) {
            throw new \RuntimeException('PENDING status not found in database. Please run fixtures.');
        }

        $allMilestones = $milestoneRepo->findAll();

        foreach ($allMilestones as $milestone) {
            $internshipMilestone = new InternshipMilestone();
            $internshipMilestone->setInternship($internship);
            $internshipMilestone->setMilestone($milestone);
            $internshipMilestone->setStatus($pendingStatus);

            $entityManager->persist($internshipMilestone);
        }
    }

    /**
     * Override entity display name for flash messages.
     */
    protected function getEntityDisplayName(object $entity): string
    {
        return 'Stage';
    }
}
