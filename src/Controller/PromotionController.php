<?php

namespace App\Controller;

use App\Controller\Trait\CrudControllerTrait;
use App\Controller\Trait\LogsExceptionDetailsTrait;
use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/promotion')]
#[IsGranted('ROLE_ADMIN')]
final class PromotionController extends AbstractController
{
    use CrudControllerTrait;
    use LogsExceptionDetailsTrait;

    #[Route(name: 'app_promotion_index', methods: ['GET'])]
    public function index(PromotionRepository $promotionRepository): Response
    {
        try {
            return $this->render('promotion/index.html.twig', [
                'promotions' => $promotionRepository->findAllOrdered(),
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e, 'Promotion index load failed');
            $this->addFlash('error', 'Erreur lors du chargement des promotions.');

            return $this->render('promotion/index.html.twig', ['promotions' => []]);
        }
    }

    #[Route('/new', name: 'app_promotion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);

        return $this->handleCreate(
            $request,
            $promotion,
            $form,
            $entityManager,
            'promotion/new.html.twig',
            'app_promotion_index'
        );
    }

    #[Route('/{id}/edit', name: 'app_promotion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Promotion $promotion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);

        return $this->handleUpdate(
            $request,
            $promotion,
            $form,
            $entityManager,
            'promotion/edit.html.twig',
            'app_promotion_index'
        );
    }
}
