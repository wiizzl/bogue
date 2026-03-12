<?php

namespace App\Controller;

use App\Repository\InternshipRepository;
use App\Repository\MajorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class InternshipTrackingController extends AbstractController
{
    #[Route('/tracking', name: 'app_internship_tracking')]
    public function index(Request $request, InternshipRepository $internshipRepo, MajorRepository $majorRepo, UserRepository $userRepo): Response
    {
        $filters = [
            'major' => $request->query->get('major'),
            'teacher' => $request->query->get('teacher'),
        ];

        $internships = $internshipRepo->findForTracking($filters, $this->getUser());

        return $this->render('internship_tracking/index.html.twig', [
            'internships' => $internships,
            'majors' => $majorRepo->findAll(),
            'teachers' => $userRepo->findAll(),
            'current_filters' => $filters
        ]);
    }
}
