<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/company')]
#[IsGranted('ROLE_ADMIN')]
final class CompanyController extends AbstractController
{
        use CrudControllerTrait;

    #[Route(name: 'app_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        try {
            return $this->render('company/index.html.twig', [
                'companies' => $companyRepository->findAll(),
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du chargement des entreprises.');
            return $this->render('company/index.html.twig', ['companies' => []]);
        }
    }

    #[Route('/new', name: 'app_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);

        return $this->handleCreate($request, $company, $form, $entityManager, 'company/new.html.twig', 'app_company_index');
    }

    #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Company $company, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompanyType::class, $company);

        return $this->handleUpdate($request, $company, $form, $entityManager, 'company/edit.html.twig', 'app_company_index');
    }

    #[Route('/{id}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$company->getId(), $request->getPayload()->getString('_token'))) {
            $this->addFlash('error', 'Token de sécurité invalide.');
            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->handleDelete($company, $entityManager, 'app_company_index');
    }

    protected function getEntityDisplayName(object $entity): string
    {
        return 'Entreprise';
    }
}
