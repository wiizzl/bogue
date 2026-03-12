<?php

namespace App\Controller;

use App\Repository\InternshipRepository;
use App\Repository\MajorRepository;
use App\Repository\MilestoneRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(name: 'app_home')]
    public function index(Request $request, InternshipRepository $internshipRepo, MajorRepository $majorRepo, UserRepository $userRepo): Response
    {
        $filters = [
            'major' => $request->query->get('major'),
            'teacher' => $request->query->get('teacher'),
        ];

        $internships = $internshipRepo->findForTracking($filters, $this->getUser());

        return $this->render('home/index.html.twig', [
            'internships' => $internships,
            'majors' => $majorRepo->findAll(),
            'teachers' => $userRepo->findAll(),
            'current_filters' => $filters
        ]);
    }

    #[Route('/export', name: 'app_export_csv', methods: ['GET'])]
    public function exportCsv(Request $request, InternshipRepository $internshipRepo, MilestoneRepository $milestoneRepo): Response
    {
        $filters = [
            'major' => $request->query->get('major'),
            'teacher' => $request->query->get('teacher'),
        ];

        $internships = $internshipRepo->findForTracking($filters, $this->getUser());
        $allMilestones = $milestoneRepo->findAll();

        $fp = fopen('php://temp', 'w');

        $headers = [
            'Étudiant',
            'Filière',
            'Entreprise',
            'Ville',
            'Prof. Suivi',
            'Prof. Visite'
        ];

        foreach ($allMilestones as $milestone) {
            $headers[] = $milestone->getLabel();
        }

        fputcsv($fp, $headers, ';');

        foreach ($internships as $internship) {
            $row = [
                strtoupper($internship->getStudent()->getLastName()) . ' ' . $internship->getStudent()->getFirstName(),
                $internship->getStudent()->getMajor()->getCode(),
                $internship->getCompany()->getName(),
                $internship->getCompany()->getCity(),
                $internship->getTrackingTeacher() ? $internship->getTrackingTeacher()->getLastName() : 'Non affecté',
                $internship->getVisitingTeacher() ? $internship->getVisitingTeacher()->getLastName() : 'Non affecté',
            ];

            foreach ($allMilestones as $milestone) {
                $statusLabel = 'Non défini';

                foreach ($internship->getMilestones() as $internshipMilestone) {
                    if ($internshipMilestone->getMilestone()->getId() === $milestone->getId()) {
                        $statusLabel = $internshipMilestone->getStatus()->getLabel();
                        break;
                    }
                }

                $row[] = $statusLabel;
            }

            fputcsv($fp, $row, ';');
        }

        rewind($fp);
        $csvContent = stream_get_contents($fp);
        fclose($fp);

        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'suivi_stages_' . date('Y-m-d') . '.csv'
        ));

        return $response;
    }
}
