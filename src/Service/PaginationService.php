<?php

namespace App\Service;

class PaginationService
{
    public const DEFAULT_ITEMS_PER_PAGE = 16;

    public function build(int $totalItems, int $requestedPage, int $limit = self::DEFAULT_ITEMS_PER_PAGE): array
    {
        $pagesCount = max(1, (int) ceil($totalItems / $limit));
        $currentPage = min(max(1, $requestedPage), $pagesCount);

        return [
            'current_page' => $currentPage,
            'pages_count' => $pagesCount,
            'total_items' => $totalItems,
            'current_limit' => $limit,
        ];
    }
}
