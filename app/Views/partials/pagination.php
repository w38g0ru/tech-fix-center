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
<div class="flex flex-col sm:flex-row justify-between items-center mt-6 space-y-4 sm:space-y-0">
    <!-- Pagination Info -->
    <div class="text-sm text-gray-700 dark:text-gray-300">
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
            Showing
            <span class="font-medium"><?= number_format($firstItem) ?></span>
            to
            <span class="font-medium"><?= number_format($lastItem) ?></span>
            of
            <span class="font-medium"><?= number_format($total) ?></span>
            results
        <?php else: ?>
            No results found
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <nav class="flex items-center space-x-1" aria-label="Pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <!-- Previous Page Link -->
            <?php
            $prevParams = $currentParams;
            $prevParams['page'] = $pager->getCurrentPageNumber() - 1;
            $queryString = http_build_query($prevParams);
            $prevUrl = current_url() . ($queryString ? '?' . $queryString : '');
            ?>
            <a href="<?= $prevUrl ?>"
               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
               aria-label="Previous page">
                <i class="fas fa-chevron-left mr-1"></i>
                Previous
            </a>
        <?php else : ?>
            <!-- Disabled Previous -->
            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-l-md cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-600">
                <i class="fas fa-chevron-left mr-1"></i>
                Previous
            </span>
        <?php endif ?>

        <!-- Page Numbers -->
        <?php foreach ($pager->links() as $link) : ?>
            <?php if ($link['active']) : ?>
                <!-- Current Page -->
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 cursor-default">
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
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
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
               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-colors duration-200"
               aria-label="Next page">
                Next
                <i class="fas fa-chevron-right ml-1"></i>
            </a>
        <?php else : ?>
            <!-- Disabled Next -->
            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-r-md cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-600">
                Next
                <i class="fas fa-chevron-right ml-1"></i>
            </span>
        <?php endif ?>
    </nav>
</div>
<?php endif ?>
