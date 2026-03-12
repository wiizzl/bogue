<?php

namespace App\Controller;

use App\Repository\HistoryLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/history')]
#[IsGranted('ROLE_ADMIN')]
final class HistoryController extends AbstractController
{
    #[Route(name: 'app_history_index', methods: ['GET'])]
    public function index(Request $request, HistoryLogRepository $historyRepo): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 25;

        $logs = $historyRepo->findGlobalHistory($page, $limit);
        $totalItems = count($logs);
        $pagesCount = ceil($totalItems / $limit);

        return $this->render('history/index.html.twig', [
            'logs' => $logs,
            'current_page' => $page,
            'pages_count' => $pagesCount,
        ]);
    }
}
