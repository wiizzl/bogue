<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\InternshipRepository;
use App\Repository\MajorRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Service responsible for internship tracking business logic.
 *
 * Handles filtering, pagination, and access control for internship data
 * based on user roles and permissions.
 */
class InternshipTrackingService
{
    public function __construct(
        private InternshipRepository $internshipRepository,
        private MajorRepository $majorRepository,
        private UserRepository $userRepository
    ) {
    }

    /**
     * Get filtered internships for tracking with pagination and access control.
     *
     * Applies role-based filtering:
     * - ADMIN: sees all internships
     * - SECRETARY: sees all internships
     * - TEACHER: sees only assigned internships
     *
     * @param array $filters Array with 'major' and 'teacher' keys
     * @param User|null $user Current authenticated user
     * @param int $page Current page number (1-based)
     * @param int|null $limit Results per page (null for no limit)
     * @return array{data: Paginator|array, pagination: array}
     */
    public function getFilteredInternships(array $filters, ?User $user, int $page = 1, ?int $limit = null): array
    {
        // Get filtered data with pagination
        $results = $this->internshipRepository->findForTracking($filters, $user, $page, $limit);

        // Calculate pagination data
        $paginationData = $this->calculatePaginationData($results, $page, $limit);

        return [
            'data' => $results,
            'pagination' => $paginationData
        ];
    }

    /**
     * Get all internships for export (no pagination).
     *
     * @param array $filters
     * @param User|null $user
     * @return array
     */
    public function getInternshipsForExport(array $filters, ?User $user): array
    {
        return $this->internshipRepository->findForTracking($filters, $user, 1, null);
    }

    /**
     * Get filter options for the UI.
     *
     * Returns available majors and teachers for building filter dropdowns.
     *
     * @return array{majors: array, teachers: array}
     */
    public function getFilterOptions(): array
    {
        return [
            'majors' => $this->majorRepository->findAll(),
            'teachers' => $this->userRepository->findTeachers()
        ];
    }

    /**
     * Validate and sanitize filter parameters.
     *
     * Ensures filter values are valid and prevents injection.
     *
     * @param array $rawFilters Raw filter data from request
     * @return array Sanitized filters
     */
    public function sanitizeFilters(array $rawFilters): array
    {
        $filters = [];

        // Validate major filter
        if (!empty($rawFilters['major']) && is_numeric($rawFilters['major'])) {
            $filters['major'] = (int) $rawFilters['major'];
        }

        // Validate teacher filter
        if (!empty($rawFilters['teacher']) && is_numeric($rawFilters['teacher'])) {
            $filters['teacher'] = (int) $rawFilters['teacher'];
        }

        return $filters;
    }

    /**
     * Check if user has access to view internship data.
     *
     * @param User|null $user
     * @return bool
     */
    public function canViewInternships(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        $userRoles = $user->getRoles();

        return in_array('ROLE_ADMIN', $userRoles) ||
               in_array('ROLE_SECRETARY', $userRoles) ||
               in_array('ROLE_TEACHER', $userRoles);
    }

    /**
     * Calculate pagination metadata.
     *
     * @param Paginator|array $results
     * @param int $page
     * @param int|null $limit
     * @return array
     */
    private function calculatePaginationData($results, int $page, ?int $limit): array
    {
        if ($limit === null) {
            // No pagination
            $totalItems = is_array($results) ? count($results) : count($results);
            return [
                'current_page' => 1,
                'pages_count' => 1,
                'total_items' => $totalItems,
                'current_limit' => $totalItems
            ];
        }

        $totalItems = count($results);
        $pagesCount = ceil($totalItems / $limit);

        return [
            'current_page' => $page,
            'pages_count' => $pagesCount,
            'total_items' => $totalItems,
            'current_limit' => $limit
        ];
    }
}
