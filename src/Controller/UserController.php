<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Controller\Trait\LogsExceptionDetailsTrait;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\DeletionCleanupService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
final class UserController extends AbstractController
{
    use CrudControllerTrait;
    use LogsExceptionDetailsTrait;

    #[Route(name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        try {
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e, 'User index load failed');
            $this->addFlash('error', 'Erreur lors du chargement des utilisateurs.');
            return $this->render('user/index.html.twig', ['users' => []]);
        }
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => 'new',
            'can_edit_roles' => true,
        ]);

        return $this->handleUserForm(
            $request,
            $user,
            $form,
            $entityManager,
            $userPasswordHasher,
            true,
            'Utilisateur créé avec succès.',
            'Erreur lors de la création.',
            'user/new.html.twig'
        );
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'], requirements: ['id' => '\\d+'])]
    public function show(User $user): Response
    {
        if (!$this->canManageUser($user)) {
            return $this->handleAccessDenied('consulter', $user);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if (!$this->canManageUser($user)) {
            return $this->handleAccessDenied('modifier', $user);
        }

        $form = $this->createForm(UserType::class, $user, [
            'action' => 'edit',
            'can_edit_roles' => false,
        ]);

        return $this->handleUserForm(
            $request,
            $user,
            $form,
            $entityManager,
            $userPasswordHasher,
            false,
            'Utilisateur mis à jour avec succès.',
            'Erreur lors de la mise à jour.',
            'user/edit.html.twig'
        );
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        DeletionCleanupService $deletionCleanupService
    ): Response
    {
        if ($this->getUser() === $user) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        $csrfErrorResponse = $this->validateDeleteCsrf($request, $user, 'app_user_index');

        if ($csrfErrorResponse instanceof Response) {
            return $csrfErrorResponse;
        }

        $deletionCleanupService->cleanupUserDeletion($user);

        return $this->handleDelete($user, $entityManager, 'app_user_index');
    }

    private function hashUserPasswordIfProvided(User $user, ?string $plainPassword, UserPasswordHasherInterface $hasher): void
    {
        if ($plainPassword) {
            $user->setPassword($hasher->hashPassword($user, $plainPassword));
        }
    }

    private function handleUserForm(
        Request $request,
        User $user,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        bool $persistOnSave,
        string $successMessage,
        string $errorMessage,
        string $template
    ): Response {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->hashUserPasswordIfProvided($user, $form->get('password')->getData(), $userPasswordHasher);

                if ($persistOnSave) {
                    $entityManager->persist($user);
                }

                $entityManager->flush();
                $this->addFlash('success', $successMessage);

                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->logExceptionDetails($e, 'User form save failed');
                $this->addFlash('error', $errorMessage);
            }
        }

        return $this->render($template, [
            'user' => $user,
            'form' => $form,
        ]);
    }

    private function canManageUser(User $target): bool
    {
        $current = $this->getUser();

        if (!$current instanceof User) {
            return false;
        }

        return $this->isGranted('ROLE_ADMIN') || $current->getId() === $target->getId();
    }
}
