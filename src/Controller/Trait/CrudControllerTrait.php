<?php

namespace App\Controller\Trait;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait providing common CRUD operations for controllers.
 *
 * This trait reduces code duplication by providing standardized methods
 * for create, update, and delete operations with proper error handling
 * and CSRF protection.
 */
trait CrudControllerTrait
{
    /**
     * Handle entity creation with form processing.
     *
     * @param Request $request
     * @param object $entity New entity instance
     * @param FormInterface $form Configured form
     * @param EntityManagerInterface $entityManager
     * @param string $template Template name for rendering
     * @param string $redirectRoute Route name for successful redirect
     * @param array $templateParams Additional template parameters
     * @return Response
     */
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

    /**
     * Handle entity update with form processing.
     *
     * @param Request $request
     * @param object $entity Existing entity
     * @param FormInterface $form Configured form
     * @param EntityManagerInterface $entityManager
     * @param string $template Template name for rendering
     * @param string $redirectRoute Route name for successful redirect
     * @param array $templateParams Additional template parameters
     * @return Response
     */
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

    /**
     * Handle entity deletion with proper CSRF protection via form.
     *
     * Uses Symfony's built-in form CSRF protection instead of manual validation.
     *
     * @param object $entity Entity to delete
     * @param EntityManagerInterface $entityManager
    * @param string $redirectRoute Route to redirect to after deletion
     * @return Response
     */
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

    /**
     * Create a simple delete form with CSRF protection.
     *
     * This replaces manual CSRF token validation with proper form-based CSRF.
     *
     * @param object $entity
     * @return FormInterface
     */
    protected function createDeleteForm(object $entity): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_' . $this->getEntityTemplateName($entity) . '_delete', ['id' => $entity->getId()]))
            ->setMethod('POST')
            ->getForm();
    }

    /**
     * Get the display name for an entity (for flash messages).
     *
     * Override this method in controllers to provide custom display names.
     *
     * @param object $entity
     * @return string
     */
    protected function getEntityDisplayName(object $entity): string
    {
        $class = get_class($entity);
        return substr($class, strrpos($class, '\\') + 1);
    }

    /**
     * Get the template variable name for an entity.
     *
     * @param object $entity
     * @return string
     */
    protected function getEntityTemplateName(object $entity): string
    {
        $class = get_class($entity);
        $shortName = substr($class, strrpos($class, '\\') + 1);
        return strtolower($shortName);
    }

    /**
     * Add consistent error handling for access denied scenarios.
     *
     * @param string $operation Operation being attempted (view, edit, delete)
     * @param object|null $entity Related entity (optional)
     * @return Response
     */
    protected function handleAccessDenied(string $operation, ?object $entity = null): Response
    {
        $entityName = $entity ? $this->getEntityDisplayName($entity) : 'cette ressource';

        $this->addFlash('error',
            sprintf('Vous n\'avez pas les permissions pour %s %s.', $operation, $entityName)
        );

        return $this->redirectToRoute('app_home_index');
    }
}
