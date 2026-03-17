<?php

namespace App\Service;

use App\Entity\Internship;
use App\Entity\Milestone;
use App\Repository\MilestoneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CsvExportService
{
    public function __construct(
        private MilestoneRepository $milestoneRepository
    ) {
    }

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

    private function buildCsvContent(array $internships): string
    {
        $fp = fopen('php://temp', 'w');

        if (!$fp) {
            throw new \RuntimeException('Unable to create temporary file for CSV export');
        }

        try {
            $milestones = $this->milestoneRepository->findAll();

            $this->writeCsvHeaders($fp, $milestones);
            $this->writeCsvData($fp, $internships, $milestones);

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

    private function writeCsvHeaders($fp, array $milestones): void
    {
        $headers = [
            'Étudiant',
            'Option',
            'Entreprise',
            'Ville',
            'Prof. Suivi',
            'Prof. Visite'
        ];

        foreach ($milestones as $milestone) {
            $headers[] = $milestone->getLabel();
        }

        $headers = array_map([$this, 'sanitizeCsvCell'], $headers);

        fputcsv($fp, $headers, ';');
    }

    private function writeCsvData($fp, array $internships, array $milestones): void
    {
        foreach ($internships as $internship) {
            $row = $this->buildInternshipRow($internship, $milestones);
            $row = array_map([$this, 'sanitizeCsvCell'], $row);
            fputcsv($fp, $row, ';');
        }
    }

    private function buildInternshipRow(Internship $internship, array $allMilestones): array
    {
        $student = $internship->getStudent();
        $company = $internship->getCompany();

        $row = [
            $student->getFullName(),
            $student->getMajor()->getCode(),
            $company->getName(),
            $company->getCity(),
            $internship->getTrackingTeacher()?->getFullName() ?? 'Aucun',
            $internship->getVisitingTeacher()?->getFullName() ?? 'Aucun',
        ];

        // Add milestone status for each milestone
        foreach ($allMilestones as $milestone) {
            $row[] = $this->getMilestoneStatus($internship, $milestone);
        }

        return $row;
    }

    private function getMilestoneStatus(Internship $internship, Milestone $milestone): string
    {
        foreach ($internship->getMilestones() as $internshipMilestone) {
            if ($internshipMilestone->getMilestone()->getId() === $milestone->getId()) {
                return $internshipMilestone->getStatus()->getLabel();
            }
        }

        return 'Non défini';
    }

    private function sanitizeCsvCell(?string $value): string
    {
        $value = (string) ($value ?? '');
        $trimmedValue = ltrim($value);

        if ($trimmedValue !== '' && preg_match('/^[=+\-@]/', $trimmedValue) === 1) {
            return "'" . $value;
        }

        return $value;
    }
}
