<?php

namespace App\Service;

use App\Entity\Internship;
use App\Entity\Milestone;
use App\Repository\MilestoneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Service responsible for generating CSV exports of internship data.
 *
 * This service handles the complex logic of building CSV content with proper
 * column mapping and data formatting for internship tracking exports.
 */
class CsvExportService
{
    public function __construct(
        private MilestoneRepository $milestoneRepository
    ) {
    }

    /**
     * Generate a CSV response containing internship tracking data.
     *
     * @param Internship[] $internships Array of internships to export
     * @param string|null $filename Custom filename (optional)
     * @return Response HTTP response with CSV content
     */
    public function generateInternshipCsv(array $internships, ?string $filename = null): Response
    {
        $csvContent = $this->buildCsvContent($internships);

        if (!$filename) {
            $filename = 'suivi_stages_' . date('Y-m-d') . '.csv';
        }

        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition',
            $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename)
        );

        return $response;
    }

    /**
     * Build the actual CSV content from internship data.
     *
     * Creates a CSV with student data, company info, assigned teachers,
     * and milestone status for each internship.
     */
    private function buildCsvContent(array $internships): string
    {
        $fp = fopen('php://temp', 'w');

        if (!$fp) {
            throw new \RuntimeException('Unable to create temporary file for CSV export');
        }

        try {
            // Build headers including dynamic milestone columns
            $this->writeCsvHeaders($fp);

            // Write data rows
            $this->writeCsvData($fp, $internships);

            rewind($fp);
            $content = stream_get_contents($fp);

            if ($content === false) {
                throw new \RuntimeException('Unable to read CSV content from temporary file');
            }

            return $content;
        } finally {
            fclose($fp);
        }
    }

    /**
     * Write CSV headers including static columns and dynamic milestone columns.
     */
    private function writeCsvHeaders($fp): void
    {
        $headers = [
            'Étudiant',
            'Filière',
            'Entreprise',
            'Ville',
            'Prof. Suivi',
            'Prof. Visite'
        ];

        // Add milestone columns dynamically
        $milestones = $this->milestoneRepository->findAll();
        foreach ($milestones as $milestone) {
            $headers[] = $milestone->getLabel();
        }

        fputcsv($fp, $headers, ';');
    }

    /**
     * Write internship data rows to CSV.
     *
     * @param resource $fp File pointer for writing
     * @param Internship[] $internships
     */
    private function writeCsvData($fp, array $internships): void
    {
        $allMilestones = $this->milestoneRepository->findAll();

        foreach ($internships as $internship) {
            $row = $this->buildInternshipRow($internship, $allMilestones);
            fputcsv($fp, $row, ';');
        }
    }

    /**
     * Build a single CSV row for an internship.
     *
     * @param Internship $internship
     * @param Milestone[] $allMilestones
     * @return array
     */
    private function buildInternshipRow(Internship $internship, array $allMilestones): array
    {
        $student = $internship->getStudent();
        $company = $internship->getCompany();

        $row = [
            strtoupper($student->getLastName()) . ' ' . $student->getFirstName(),
            $student->getMajor()->getCode(),
            $company->getName(),
            $company->getCity(),
            $internship->getTrackingTeacher()?->getLastName() ?? 'Non affecté',
            $internship->getVisitingTeacher()?->getLastName() ?? 'Non affecté',
        ];

        // Add milestone status for each milestone
        foreach ($allMilestones as $milestone) {
            $row[] = $this->getMilestoneStatus($internship, $milestone);
        }

        return $row;
    }

    /**
     * Get the status label for a specific milestone in an internship.
     *
     * Returns the status label if the milestone is found, otherwise 'Non défini'.
     */
    private function getMilestoneStatus(Internship $internship, Milestone $milestone): string
    {
        foreach ($internship->getMilestones() as $internshipMilestone) {
            if ($internshipMilestone->getMilestone()->getId() === $milestone->getId()) {
                return $internshipMilestone->getStatus()->getLabel();
            }
        }

        return 'Non défini';
    }
}