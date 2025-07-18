<?php

/**
 * Pagination Helper Functions
 * 
 * Helper functions for pagination display and management
 */

if (!function_exists('renderPagination')) {
    /**
     * Render pagination links using custom template
     *
     * @param object $pager The pager object from model
     * @param string $template The pagination template to use
     * @param bool $withWrapper Whether to wrap pagination in a container
     * @return string
     */
    function renderPagination($pager, $template = 'custom_full', $withWrapper = true)
    {
        if (!$pager || !method_exists($pager, 'getPageCount') || $pager->getPageCount() <= 1) {
            return '';
        }

        try {
            $paginationHtml = $pager->links('default', $template);

            if ($withWrapper && !empty($paginationHtml)) {
                return '<div class="mt-6">' . $paginationHtml . '</div>';
            }

            return $paginationHtml;
        } catch (Exception $e) {
            // Fallback to default pagination if custom template fails
            return $pager->links();
        }
    }
}

if (!function_exists('renderCompactPagination')) {
    /**
     * Render compact pagination for smaller spaces
     *
     * @param object $pager The pager object from model
     * @return string
     */
    function renderCompactPagination($pager)
    {
        if (!$pager || !method_exists($pager, 'getPageCount') || $pager->getPageCount() <= 1) {
            return '';
        }

        $currentPage = $pager->getCurrentPageNumber();
        $totalPages = $pager->getPageCount();
        $total = $pager->getTotal();

        // Get current URI and preserve query parameters
        $request = service('request');
        $currentParams = $request->getGet();

        $html = '<div class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">';

        // Compact info
        $html .= '<div class="text-sm text-gray-600 dark:text-gray-400">';
        $html .= 'Page <span class="font-medium">' . $currentPage . '</span> of <span class="font-medium">' . $totalPages . '</span>';
        $html .= ' (<span class="font-medium">' . number_format($total) . '</span> total)';
        $html .= '</div>';

        // Compact navigation
        $html .= '<div class="flex items-center space-x-2">';

        // Previous button
        if ($pager->hasPrevious()) {
            $prevParams = $currentParams;
            $prevParams['page'] = $currentPage - 1;
            $queryString = http_build_query($prevParams);
            $prevUrl = current_url() . ($queryString ? '?' . $queryString : '');

            $html .= '<a href="' . $prevUrl . '" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">';
            $html .= '<i class="fas fa-chevron-left text-xs"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md cursor-not-allowed">';
            $html .= '<i class="fas fa-chevron-left text-xs"></i>';
            $html .= '</span>';
        }

        // Next button
        if ($pager->hasNext()) {
            $nextParams = $currentParams;
            $nextParams['page'] = $currentPage + 1;
            $queryString = http_build_query($nextParams);
            $nextUrl = current_url() . ($queryString ? '?' . $queryString : '');

            $html .= '<a href="' . $nextUrl . '" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">';
            $html .= '<i class="fas fa-chevron-right text-xs"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md cursor-not-allowed">';
            $html .= '<i class="fas fa-chevron-right text-xs"></i>';
            $html .= '</span>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('getPaginationInfo')) {
    /**
     * Get pagination information for display
     * 
     * @param object $pager The pager object from model
     * @return array
     */
    function getPaginationInfo($pager)
    {
        if (!$pager) {
            return [
                'current_page' => 1,
                'per_page' => 20,
                'total' => 0,
                'first_item' => 0,
                'last_item' => 0,
                'page_count' => 0
            ];
        }

        $currentPage = $pager->getCurrentPageNumber();
        $perPage = $pager->getPerPage();
        $total = $pager->getTotal();
        $firstItem = (($currentPage - 1) * $perPage) + 1;
        $lastItem = min($currentPage * $perPage, $total);

        return [
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total' => $total,
            'first_item' => $firstItem,
            'last_item' => $lastItem,
            'page_count' => $pager->getPageCount()
        ];
    }
}

if (!function_exists('buildPaginationUrl')) {
    /**
     * Build pagination URL with existing query parameters
     * 
     * @param string $baseUrl Base URL for pagination
     * @param array $params Additional query parameters to preserve
     * @return string
     */
    function buildPaginationUrl($baseUrl, $params = [])
    {
        $request = service('request');
        $currentParams = $request->getGet();
        
        // Remove page parameter to avoid conflicts
        unset($currentParams['page']);
        
        // Merge with additional parameters
        $allParams = array_merge($currentParams, $params);
        
        if (!empty($allParams)) {
            $baseUrl .= '?' . http_build_query($allParams);
        }
        
        return $baseUrl;
    }
}

if (!function_exists('renderSimplePagination')) {
    /**
     * Render simple pagination template
     *
     * @param object $pager The pager object from model
     * @return string
     */
    function renderSimplePagination($pager)
    {
        if (!$pager || !method_exists($pager, 'getPageCount') || $pager->getPageCount() <= 1) {
            return '';
        }

        try {
            return $pager->links('default', 'custom_simple');
        } catch (Exception $e) {
            return renderCompactPagination($pager);
        }
    }
}

if (!function_exists('getPerPageOptions')) {
    /**
     * Get available per-page options for pagination
     *
     * @return array
     */
    function getPerPageOptions()
    {
        return [
            10 => '10 per page',
            20 => '20 per page',
            50 => '50 per page',
            100 => '100 per page'
        ];
    }
}

if (!function_exists('renderPaginationWithInfo')) {
    /**
     * Render pagination with additional info and controls
     *
     * @param object $pager The pager object from model
     * @param array $options Additional options (show_per_page, show_info, etc.)
     * @return string
     */
    function renderPaginationWithInfo($pager, $options = [])
    {
        if (!$pager || !method_exists($pager, 'getPageCount')) {
            return '';
        }

        $showPerPage = $options['show_per_page'] ?? false;
        $showInfo = $options['show_info'] ?? true;
        $template = $options['template'] ?? 'custom_full';

        $html = '';

        // Additional info section
        if ($showInfo || $showPerPage) {
            $html .= '<div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">';

            if ($showInfo) {
                $info = getPaginationInfo($pager);
                $html .= '<div class="text-sm text-gray-600 dark:text-gray-400">';
                $html .= 'Total: <span class="font-medium">' . number_format($info['total']) . '</span> items';
                $html .= '</div>';
            }

            if ($showPerPage) {
                $currentPerPage = $pager->getPerPage();
                $html .= '<div class="flex items-center space-x-2">';
                $html .= '<label for="perPage" class="text-sm text-gray-600 dark:text-gray-400">Show:</label>';
                $html .= '<select id="perPage" class="text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" onchange="changePerPage(this.value)">';

                foreach (getPerPageOptions() as $value => $label) {
                    $selected = ($value == $currentPerPage) ? 'selected' : '';
                    $html .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                }

                $html .= '</select>';
                $html .= '</div>';
            }

            $html .= '</div>';
        }

        // Pagination links
        if ($pager->getPageCount() > 1) {
            $html .= renderPagination($pager, $template, false);
        }

        return $html;
    }
}
