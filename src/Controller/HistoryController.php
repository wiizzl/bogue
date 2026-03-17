<?php

namespace App\Controller;

use App\Repository\HistoryLogRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/history')]
#[IsGranted('ROLE_ADMIN')]
final class HistoryController extends AbstractController
{
    public function __construct(private PaginationService $paginationService)
    {
    }

    #[Route(name: 'app_history_index', methods: ['GET'])]
    public function index(Request $request, HistoryLogRepository $historyRepo): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = PaginationService::DEFAULT_ITEMS_PER_PAGE;

        try {
            $logs = $historyRepo->findGlobalHistory($page, $limit);
            $pagination = $this->paginationService->build(count($logs), $page, $limit);

            return $this->render('history/index.html.twig', [
                'logs' => $logs,
                'current_page' => $pagination['current_page'],
                'pages_count' => $pagination['pages_count'],
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors du chargement de l\'historique.');

            return $this->render('history/index.html.twig', [
                'logs' => [],
                'current_page' => 1,
                'pages_count' => 1,
            ]);
        }
    }
}
