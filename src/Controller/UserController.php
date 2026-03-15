<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
final class UserController extends AbstractController
{
    use CrudControllerTrait;

    #[Route(name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        try {
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        } catch (\Exception $e) {
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->hashUserPasswordIfProvided($user, $form->get('password')->getData(), $userPasswordHasher);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Utilisateur cree avec succes.');
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la creation.');
            }
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
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
            'can_edit_roles' => $this->isGranted('ROLE_ADMIN'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->hashUserPasswordIfProvided($user, $form->get('password')->getData(), $userPasswordHasher);
                $entityManager->flush();
                $this->addFlash('success', 'Utilisateur mis a jour avec succes.');
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la mise a jour.');
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() === $user) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        $csrfErrorResponse = $this->validateDeleteCsrf($request, $user, 'app_user_index');

        if ($csrfErrorResponse instanceof Response) {
            return $csrfErrorResponse;
        }

        return $this->handleDelete($user, $entityManager, 'app_user_index');
    }

    private function hashUserPasswordIfProvided(User $user, ?string $plainPassword, UserPasswordHasherInterface $hasher): void
    {
        if ($plainPassword) {
            $user->setPassword($hasher->hashPassword($user, $plainPassword));
        }
    }

    private function canManageUser(User $target): bool
    {
        $current = $this->getUser();

        if (!$current instanceof User) {
            return false;
        }

        return $this->isGranted('ROLE_ADMIN') || $current->getId() === $target->getId();
    }

    protected function getEntityDisplayName(object $entity): string
    {
        return 'Utilisateur';
    }
}
