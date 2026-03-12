<?php

namespace App\Controller;

use App\Entity\InternshipMilestone;
use App\Form\InternshipMilestoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MilestoneUpdateController extends AbstractController
{
    #[Route('/milestone/{id}/edit', name: 'app_milestone_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InternshipMilestone $internshipMilestone, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('EDIT_MILESTONE', $internshipMilestone);

        $form = $this->createForm(InternshipMilestoneType::class, $internshipMilestone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_internship_tracking');
        }

        return $this->render('milestone/edit.html.twig', [
            'milestone' => $internshipMilestone,
            'form' => $form,
        ]);
    }
}
