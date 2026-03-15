<?php

namespace App\Controller\Trait;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
trait CrudControllerTrait
{
    protected function handleCreate(
        Request $request,
        object $entity,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        string $template,
        string $redirectRoute,
        array $templateParams = []
    ): Response {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($entity);
                $entityManager->flush();

                $this->addFlash('success',
                    sprintf('%s créé(e) avec succès.', $this->getEntityDisplayName($entity))
                );

                return $this->redirectToRoute($redirectRoute, [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error',
                    'Erreur lors de la création.'
                );
            }
        }

        $templateParams = array_merge($templateParams, [
            'form' => $form,
            $this->getEntityTemplateName($entity) => $entity
        ]);

        return $this->render($template, $templateParams);
    }

    protected function handleUpdate(
        Request $request,
        object $entity,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        string $template,
        string $redirectRoute,
        array $templateParams = []
    ): Response {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->addFlash('success',
                    sprintf('%s mis(e) à jour avec succès.', $this->getEntityDisplayName($entity))
                );

                return $this->redirectToRoute($redirectRoute, [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error',
                    'Erreur lors de la mise à jour.'
                );
            }
        }

        $templateParams = array_merge($templateParams, [
            'form' => $form,
            $this->getEntityTemplateName($entity) => $entity
        ]);

        return $this->render($template, $templateParams);
    }

    protected function handleDelete(
        object $entity,
        EntityManagerInterface $entityManager,
        string $redirectRoute
    ): Response {
        try {
            $entityManager->remove($entity);
            $entityManager->flush();

            $this->addFlash('success',
                sprintf('%s supprimé(e) avec succès.', $this->getEntityDisplayName($entity))
            );
        } catch (\Exception $e) {
            $this->addFlash('error',
                'Erreur lors de la suppression.'
            );
        }

        return $this->redirectToRoute($redirectRoute, [], Response::HTTP_SEE_OTHER);
    }

    protected function createDeleteForm(object $entity): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_' . $this->getEntityTemplateName($entity) . '_delete', ['id' => $entity->getId()]))
            ->setMethod('POST')
            ->getForm();
    }

    protected function validateDeleteCsrf(Request $request, object $entity, string $redirectRoute): ?Response
    {
        $isValid = $this->isCsrfTokenValid(
            'delete'.$entity->getId(),
            $request->getPayload()->getString('_token')
        );

        if ($isValid) {
            return null;
        }

        $this->addFlash('error', 'Token de sécurité invalide.');

        return $this->redirectToRoute($redirectRoute, [], Response::HTTP_SEE_OTHER);
    }

    protected function getEntityDisplayName(object $entity): string
    {
        $class = get_class($entity);
        return substr($class, strrpos($class, '\\') + 1);
    }

    protected function getEntityTemplateName(object $entity): string
    {
        $class = get_class($entity);
        $shortName = substr($class, strrpos($class, '\\') + 1);
        return strtolower($shortName);
    }

    protected function handleAccessDenied(string $operation, ?object $entity = null): Response
    {
        $entityName = $entity ? $this->getEntityDisplayName($entity) : 'cette ressource';

        $this->addFlash('error',
            sprintf('Vous n\'avez pas les permissions pour %s %s.', $operation, $entityName)
        );

        return $this->redirectToRoute('app_home_index');
    }
}
