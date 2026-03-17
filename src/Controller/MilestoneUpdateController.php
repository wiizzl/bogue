<?php

namespace App\Controller;

use App\Controller\Trait\LogsExceptionDetailsTrait;
use App\Entity\InternshipMilestone;
use App\Form\InternshipMilestoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class MilestoneUpdateController extends AbstractController
{
    use LogsExceptionDetailsTrait;

    /**
     * Edit a specific milestone status for an internship.
     *
     * Access is controlled by InternshipMilestoneVoter:
     * - ADMIN: always allowed
     * - TEACHER: only for their assigned internships (tracking or visiting)
     * - SECRETARY: not allowed
     */
    #[Route('/milestone/{id}/edit', name: 'app_milestone_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InternshipMilestone $internshipMilestone, EntityManagerInterface $entityManager): Response
    {
        try {
            $this->denyAccessUnlessGranted('EDIT_MILESTONE', $internshipMilestone);
        } catch (AccessDeniedException $e) {
            $this->logExceptionDetails($e, 'Milestone edit access denied');
            $this->addFlash('error', 'Vous n\'avez pas les permissions pour modifier ce jalon.');
            return $this->redirectToRoute('app_home_index');
        }

        $form = $this->createForm(InternshipMilestoneType::class, $internshipMilestone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();
                $this->addFlash('success', 'Jalon mis à jour avec succès.');
            } catch (\Exception $e) {
                $this->logExceptionDetails($e, 'Milestone update failed');
                $this->addFlash('error', 'Erreur lors de la mise à jour du jalon.');
            }

            return $this->redirectToRoute('app_home_index');
        }

        return $this->render('milestone/edit.html.twig', [
            'milestone' => $internshipMilestone,
            'form' => $form,
        ]);
    }
}
