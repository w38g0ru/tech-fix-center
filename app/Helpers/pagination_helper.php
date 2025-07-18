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
     * @return string
     */
    function renderPagination($pager, $template = 'custom_full')
    {
        if (!$pager || !method_exists($pager, 'getPageCount') || $pager->getPageCount() <= 1) {
            return '';
        }

        try {
            return $pager->links('default', $template);
        } catch (Exception $e) {
            // Fallback to default pagination if custom template fails
            return $pager->links();
        }
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
