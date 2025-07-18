<?php
/**
 * Custom Pagination Template for TeknoPhix
 *
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);

// Get current URI and preserve query parameters
$request = service('request');
$currentParams = $request->getGet();
?>

<?php if ($pager->getPageCount() > 1) : ?>
<div class="bg-white dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700 rounded-b-lg shadow-sm">
    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <!-- Pagination Info -->
        <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">
            <?php
            $currentPage = $pager->getCurrentPageNumber();
            $perPage = $pager->getPerPage();
            $total = $pager->getTotal();

            if ($total > 0) {
                $firstItem = (($currentPage - 1) * $perPage) + 1;
                $lastItem = min($currentPage * $perPage, $total);
            } else {
                $firstItem = 0;
                $lastItem = 0;
            }
            ?>
            <?php if ($total > 0): ?>
                <div class="flex items-center space-x-1">
                    <span>Showing</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100"><?= number_format($firstItem) ?></span>
                    <span>to</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100"><?= number_format($lastItem) ?></span>
                    <span>of</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100"><?= number_format($total) ?></span>
                    <span>results</span>
                </div>
            <?php else: ?>
                <span class="text-gray-500 dark:text-gray-400">No results found</span>
            <?php endif; ?>
        </div>

        <!-- Pagination Links -->
        <nav class="flex items-center" aria-label="Pagination">
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm overflow-hidden">
                <?php if ($pager->hasPrevious()) : ?>
                    <!-- Previous Page Link -->
                    <?php
                    $prevParams = $currentParams;
                    $prevParams['page'] = $pager->getCurrentPageNumber() - 1;
                    $queryString = http_build_query($prevParams);
                    $prevUrl = current_url() . ($queryString ? '?' . $queryString : '');
                    ?>
                    <a href="<?= $prevUrl ?>"
                       class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 border-r border-gray-300 dark:border-gray-600 transition-all duration-200"
                       aria-label="Previous page">
                        <i class="fas fa-chevron-left mr-2 text-xs"></i>
                        <span class="hidden sm:inline">Previous</span>
                        <span class="sm:hidden">Prev</span>
                    </a>
                <?php else : ?>
                    <!-- Disabled Previous -->
                    <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed border-r border-gray-300 dark:border-gray-600">
                        <i class="fas fa-chevron-left mr-2 text-xs"></i>
                        <span class="hidden sm:inline">Previous</span>
                        <span class="sm:hidden">Prev</span>
                    </span>
                <?php endif ?>

                <!-- Page Numbers -->
                <?php foreach ($pager->links() as $link) : ?>
                    <?php if ($link['active']) : ?>
                        <!-- Current Page -->
                        <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 dark:bg-blue-500 border-r border-blue-700 dark:border-blue-400 cursor-default min-w-[44px] justify-center">
                            <?= $link['title'] ?>
                        </span>
                    <?php else : ?>
                        <!-- Page Link -->
                        <?php
                        $pageParams = $currentParams;
                        $pageParams['page'] = $link['title'];
                        $queryString = http_build_query($pageParams);
                        $pageUrl = current_url() . ($queryString ? '?' . $queryString : '');
                        ?>
                        <a href="<?= $pageUrl ?>"
                           class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 border-r border-gray-300 dark:border-gray-600 transition-all duration-200 min-w-[44px] justify-center">
                            <?= $link['title'] ?>
                        </a>
                    <?php endif ?>
                <?php endforeach ?>

                <?php if ($pager->hasNext()) : ?>
                    <!-- Next Page Link -->
                    <?php
                    $nextParams = $currentParams;
                    $nextParams['page'] = $pager->getCurrentPageNumber() + 1;
                    $queryString = http_build_query($nextParams);
                    $nextUrl = current_url() . ($queryString ? '?' . $queryString : '');
                    ?>
                    <a href="<?= $nextUrl ?>"
                       class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-200"
                       aria-label="Next page">
                        <span class="hidden sm:inline">Next</span>
                        <span class="sm:hidden">Next</span>
                        <i class="fas fa-chevron-right ml-2 text-xs"></i>
                    </a>
                <?php else : ?>
                    <!-- Disabled Next -->
                    <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                        <span class="hidden sm:inline">Next</span>
                        <span class="sm:hidden">Next</span>
                        <i class="fas fa-chevron-right ml-2 text-xs"></i>
                    </span>
                <?php endif ?>
            </div>
        </nav>
    </div>
</div>
<?php endif ?>
