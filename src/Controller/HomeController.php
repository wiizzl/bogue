<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CsvExportService;
use App\Service\InternshipTrackingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    private const ITEMS_PER_PAGE = 15;

    public function __construct(
        private InternshipTrackingService $internshipTrackingService,
        private CsvExportService $csvExportService
    ) {
    }

    /**
     * Display internship tracking dashboard with filtering and pagination.
     *
     * Handles role-based access control and data filtering for tracking teachers.
     * Provides pagination and filtering capabilities for efficient data navigation.
     */
    #[Route(name: 'app_home_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Validate user has access to internship data
        if (!$this->internshipTrackingService->canViewInternships($this->getUser())) {
            return $this->handleAccessDenied('consulter les stages');
        }

        // Parse and validate request parameters
        $page = max(1, $request->query->getInt('page', 1));
        $limit = self::ITEMS_PER_PAGE;

        // Sanitize filters to prevent injection
        $rawFilters = [
            'major' => $request->query->get('major'),
            'teacher' => $request->query->get('teacher'),
        ];
        $filters = $this->internshipTrackingService->sanitizeFilters($rawFilters);

        try {
            // Get filtered data with pagination
            $result = $this->internshipTrackingService->getFilteredInternships(
                $filters,
                $this->getUser(),
                $page,
                $limit
            );

            // Get filter options for dropdowns
            $filterOptions = $this->internshipTrackingService->getFilterOptions();

            return $this->render('home/index.html.twig', array_merge($result['pagination'], [
                'internships' => $result['data'],
                'majors' => $filterOptions['majors'],
                'teachers' => $filterOptions['teachers'],
                'current_filters' => $filters
            ]));
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du chargement des données.');

            return $this->render('home/index.html.twig', [
                'internships' => [],
                'current_page' => 1,
                'pages_count' => 0,
                'total_items' => 0,
                'current_limit' => $limit,
                'majors' => [],
                'teachers' => [],
                'current_filters' => []
            ]);
        }
    }

    /**
     * Export internship tracking data as CSV.
     *
     * Generates a CSV file with all filtered internship data including
     * student information, company details, and milestone statuses.
     */
    #[Route('/export', name: 'app_home_export', methods: ['GET'])]
    public function exportCsv(Request $request): Response
    {
        if (!$this->isGranted('ROLE_SECRETARY')) {
            return $this->handleAccessDenied('exporter les stages');
        }

        try {
            // Sanitize filters for export (same as index)
            $rawFilters = [
                'major' => $request->query->get('major'),
                'teacher' => $request->query->get('teacher'),
            ];
            $filters = $this->internshipTrackingService->sanitizeFilters($rawFilters);

            // Get all internships for export (no pagination)
            $internships = $this->internshipTrackingService->getInternshipsForExport(
                $filters,
                $this->getUser()
            );

            // Generate and return CSV response
            return $this->csvExportService->generateInternshipCsv($internships);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de l\'export CSV.');
            return $this->redirectToRoute('app_home_index');
        }
    }

    /**
     * Handle access denied scenarios with user feedback.
     *
     * @param string $action Action being denied
     * @return Response
     */
    private function handleAccessDenied(string $action): Response
    {
        $this->addFlash('error', "Vous n'avez pas les permissions pour $action.");

        $user = $this->getUser();
        if ($user instanceof User) {
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->redirectToRoute('app_login');
    }
}
