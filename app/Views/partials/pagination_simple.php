<?php
/**
 * Simple Pagination Template for TeknoPhix
 * Minimal styling for compact spaces
 *
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(1);

// Get current URI and preserve query parameters
$request = service('request');
$currentParams = $request->getGet();
?>

<?php if ($pager->getPageCount() > 1) : ?>
<div class="flex items-center justify-between py-3 px-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
    <!-- Simple Info -->
    <div class="text-sm text-gray-600 dark:text-gray-400">
        <?php
        $currentPage = $pager->getCurrentPageNumber();
        $totalPages = $pager->getPageCount();
        $total = $pager->getTotal();
        ?>
        Page <span class="font-medium text-gray-900 dark:text-gray-100"><?= $currentPage ?></span> 
        of <span class="font-medium text-gray-900 dark:text-gray-100"><?= $totalPages ?></span>
        <span class="hidden sm:inline">
            (<span class="font-medium text-gray-900 dark:text-gray-100"><?= number_format($total) ?></span> total)
        </span>
    </div>

    <!-- Simple Navigation -->
    <div class="flex items-center space-x-1">
        <?php if ($pager->hasPrevious()) : ?>
            <!-- Previous Page Link -->
            <?php
            $prevParams = $currentParams;
            $prevParams['page'] = $pager->getCurrentPageNumber() - 1;
            $queryString = http_build_query($prevParams);
            $prevUrl = current_url() . ($queryString ? '?' . $queryString : '');
            ?>
            <a href="<?= $prevUrl ?>"
               class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-colors"
               aria-label="Previous page">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
        <?php else : ?>
            <span class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                <i class="fas fa-chevron-left text-xs"></i>
            </span>
        <?php endif ?>

        <!-- Page Numbers (limited) -->
        <?php 
        $links = $pager->links();
        $linkCount = count($links);
        $maxLinks = 3; // Show maximum 3 page numbers on mobile
        
        if ($linkCount <= $maxLinks) {
            $displayLinks = $links;
        } else {
            // Show first, current, and last pages
            $displayLinks = [];
            foreach ($links as $index => $link) {
                if ($index < 1 || $index >= $linkCount - 1 || $link['active']) {
                    $displayLinks[] = $link;
                }
            }
        }
        ?>
        
        <?php foreach ($displayLinks as $link) : ?>
            <?php if ($link['active']) : ?>
                <!-- Current Page -->
                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-600 dark:bg-blue-500 rounded cursor-default">
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
                   class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition-colors">
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
               class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-colors"
               aria-label="Next page">
                <i class="fas fa-chevron-right text-xs"></i>
            </a>
        <?php else : ?>
            <span class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                <i class="fas fa-chevron-right text-xs"></i>
            </span>
        <?php endif ?>
    </div>
</div>
<?php endif ?>
