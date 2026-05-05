<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\Trait\LogsExceptionDetailsTrait;
use App\Service\CsvExportService;
use App\Service\InternshipTrackingService;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    use LogsExceptionDetailsTrait;

    public function __construct(
        private InternshipTrackingService $internshipTrackingService,
        private CsvExportService $csvExportService
    ) {
    }

    #[Route(name: 'app_home_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        if (!$this->internshipTrackingService->canViewInternships($this->getUser())) {
            return $this->handleAccessDenied('consulter les stages');
        }

        $page = max(1, $request->query->getInt('page', 1));
        $limit = PaginationService::DEFAULT_ITEMS_PER_PAGE;

        $filters = $this->getFilters($request);

        try {
            $result = $this->internshipTrackingService->getFilteredInternships(
                $filters,
                $this->getUser(),
                $page,
                $limit
            );

            $filterOptions = $this->internshipTrackingService->getFilterOptions();

            return $this->render('home/index.html.twig', array_merge($result['pagination'], [
                'internships' => $result['data'],
                'majors' => $filterOptions['majors'],
                'promotions' => $filterOptions['promotions'],
                'teachers' => $filterOptions['teachers'],
                'current_filters' => $filters
            ]));
        } catch (\Exception $e) {
            $this->logExceptionDetails($e, 'Home index load failed');
            $this->addFlash('error', 'Erreur lors du chargement des données.');

            return $this->render('home/index.html.twig', [
                'internships' => [],
                'current_page' => 1,
                'pages_count' => 1,
                'total_items' => 0,
                'current_limit' => $limit,
                'majors' => [],
                'promotions' => [],
                'teachers' => [],
                'current_filters' => []
            ]);
        }
    }

    #[Route('/export', name: 'app_home_export', methods: ['GET'])]
    public function exportCsv(Request $request): Response
    {
        if (!$this->isGranted('ROLE_SECRETARY')) {
            return $this->handleAccessDenied('exporter les stages');
        }

        try {
            $filters = $this->getFilters($request);

            $internships = $this->internshipTrackingService->getInternshipsForExport(
                $filters,
                $this->getUser()
            );

            return $this->csvExportService->generateInternshipCsv($internships);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e, 'Home CSV export failed');
            $this->addFlash('error', 'Erreur lors de l\'export CSV.');
            return $this->redirectToRoute('app_home_index');
        }
    }

    private function handleAccessDenied(string $action): Response
    {
        $this->addFlash('error', "Vous n'avez pas les permissions pour $action.");

        $user = $this->getUser();
        if ($user instanceof User) {
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->redirectToRoute('app_login');
    }

    private function getFilters(Request $request): array
    {
        return $this->internshipTrackingService->sanitizeFilters([
            'major' => $request->query->get('major'),
            'promotion' => $request->query->get('promotion'),
            'teacher' => $request->query->get('teacher'),
        ]);
    }
}
