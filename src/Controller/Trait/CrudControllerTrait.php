<?php

namespace App\Controller\Trait;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
trait CrudControllerTrait
{
    use LogsExceptionDetailsTrait;

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

                $this->addFlash('success', 'Entitée créée avec succès.');

                return $this->redirectToRoute($redirectRoute, [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->logExceptionDetails($e, 'CRUD create failed');
                $this->addFlash('error', 'Erreur lors de la création.');
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

                $this->addFlash('success', 'Entitée mise à jour avec succès.');

                return $this->redirectToRoute($redirectRoute, [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->logExceptionDetails($e, 'CRUD update failed');
                $this->addFlash('error', 'Erreur lors de la mise à jour.');
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

            $this->addFlash('success', 'Entitée supprimée avec succès.');
        } catch (\Exception $e) {
            $this->logExceptionDetails($e, 'CRUD delete failed');
            $this->addFlash('error', 'Erreur lors de la suppression.');
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

    protected function getEntityTemplateName(object $entity): string
    {
        $class = get_class($entity);
        $shortName = substr($class, strrpos($class, '\\') + 1);
        return strtolower($shortName);
    }

    protected function handleAccessDenied(string $operation, ?object $entity = null): Response
    {
        $this->addFlash('error', 'Vous n\'avez pas les permissions pour faire cela.');

        return $this->redirectToRoute('app_home_index');
    }
}
