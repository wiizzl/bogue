<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Entity\Internship;
use App\Entity\InternshipMilestone;
use App\Form\InternshipType;
use App\Repository\InternshipRepository;
use App\Repository\MilestoneRepository;
use App\Repository\MilestoneStatusRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/internship')]
final class InternshipController extends AbstractController
{
    use CrudControllerTrait;

    public function __construct(private PaginationService $paginationService)
    {
    }

    #[Route(name: 'app_internship_index', methods: ['GET'])]
    #[IsGranted('ROLE_SECRETARY')]
    public function index(Request $request, InternshipRepository $internshipRepository): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = PaginationService::DEFAULT_ITEMS_PER_PAGE;

        try {
            $totalItems = $internshipRepository->countForIndex();
            $pagination = $this->paginationService->build($totalItems, $page, $limit);
            $currentPage = $pagination['current_page'];

            return $this->render('internship/index.html.twig', [
                'internships' => $internshipRepository->findForIndex($currentPage, $limit),
                'current_page' => $pagination['current_page'],
                'pages_count' => $pagination['pages_count'],
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du chargement des stages.');
            return $this->render('internship/index.html.twig', [
                'internships' => [],
                'current_page' => 1,
                'pages_count' => 1,
            ]);
        }
    }

    #[Route('/new', name: 'app_internship_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
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
                $entityManager->beginTransaction();

                $entityManager->persist($internship);

                $this->initializeInternshipMilestones($internship, $milestoneRepo, $statusRepo, $entityManager);

                $entityManager->flush();
                $entityManager->commit();

                $this->addFlash('success', 'Stage créé avec succès et jalons initialisés.');
                return $this->redirectToRoute('app_internship_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $entityManager->rollback();
                $this->addFlash('error', 'Erreur lors de la création du stage.');
            }
        }

        return $this->render('internship/new.html.twig', [
            'internship' => $internship,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_internship_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Internship $internship): Response
    {
        if (!$this->isGranted('VIEW_INTERNSHIP', $internship)) {
            return $this->handleAccessDenied('consulter', $internship);
        }

        return $this->render('internship/show.html.twig', [
            'internship' => $internship,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_internship_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Internship $internship, EntityManagerInterface $entityManager): Response
    {
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

    #[Route('/{id}', name: 'app_internship_delete', methods: ['POST'])]
    public function delete(Request $request, Internship $internship, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->handleAccessDenied('supprimer', $internship);
        }

        $csrfErrorResponse = $this->validateDeleteCsrf($request, $internship, 'app_internship_index');

        if ($csrfErrorResponse instanceof Response) {
            return $csrfErrorResponse;
        }

        return $this->handleDelete($internship, $entityManager, 'app_internship_index');
    }

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
}
