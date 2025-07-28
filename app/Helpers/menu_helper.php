<?php

use App\Config\MenuConfig;

if (!function_exists('renderMenuItems')) {
    /**
     * Render menu items for dashboard layouts
     * 
     * @param string $theme 'light' or 'dark'
     * @param bool $compact Whether to use compact styling
     * @return string HTML output
     */
    function renderMenuItems(string $theme = 'light', bool $compact = true): string
    {
        $menuItems = MenuConfig::getMenuItems();
        $html = '';
        
        foreach ($menuItems as $section) {
            // Check section access level
            if (!MenuConfig::hasAccessLevel($section['access_level'] ?? 'all')) {
                continue;
            }

            // Check if section has any visible items
            $visibleItems = [];
            foreach ($section['items'] as $item) {
                if (MenuConfig::hasAccessLevel($item['access_level'] ?? 'all')) {
                    $visibleItems[] = $item;
                }
            }

            // Skip section if no visible items
            if (empty($visibleItems)) {
                continue;
            }

            // Render section header
            $html .= renderSectionHeader($section['section'], $theme, $compact);

            // Render visible section items
            foreach ($visibleItems as $item) {
                $html .= renderMenuItem($item, $theme, $compact);
            }

            $html .= '</div>' . PHP_EOL . PHP_EOL;
        }
        
        return $html;
    }
}

if (!function_exists('renderSectionHeader')) {
    /**
     * Render section header
     */
    function renderSectionHeader(string $sectionName, string $theme, bool $compact): string
    {
        $marginClass = $compact ? 'mt-6 mb-2' : 'mt-8 mb-3';

        if ($theme === 'dark') {
            $textColor = 'text-gray-500';
        } else {
            $textColor = 'text-gray-500';
        }

        return <<<HTML
                <!-- {$sectionName} Section -->
                <div class="{$marginClass}">
                    <div class="px-4 mb-2">
                        <h3 class="text-xs font-medium {$textColor} uppercase tracking-wide">{$sectionName}</h3>
                        <div class="mt-1 h-px bg-gray-200"></div>
                    </div>

HTML;
    }
}

if (!function_exists('renderMenuItem')) {
    /**
     * Render individual menu item
     */
    function renderMenuItem(array $item, string $theme, bool $compact): string
    {
        $isActive = MenuConfig::isActive(
            $item['active_check'] ?? [],
            $item['exclude_check'] ?? []
        );
        
        $url = base_url($item['url']);
        $name = $item['name'];
        $icon = $item['icon'];
        $color = $item['color'];
        
        if ($theme === 'dark') {
            return renderDarkMenuItem($item, $isActive, $compact);
        } else {
            return renderLightMenuItem($item, $isActive, $compact);
        }
    }
}

if (!function_exists('renderLightMenuItem')) {
    /**
     * Render menu item for light theme
     */
    function renderLightMenuItem(array $item, bool $isActive, bool $compact): string
    {
        $url = base_url($item['url']);
        $name = $item['name'];
        $icon = $item['icon'];

        $activeClass = $isActive ? 'text-fuchsia-600 bg-fuchsia-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50';

        return <<<HTML
                <!-- {$name} -->
                <a href="{$url}"
                   class="nav-link flex items-center px-4 py-2 text-sm font-medium transition-colors duration-200 {$activeClass} mb-1 mx-2 rounded-lg"
                   title="{$name}">
                    <i class="{$icon} w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span class="nav-text">{$name}</span>
                </a>

HTML;
    }
}

if (!function_exists('renderDarkMenuItem')) {
    /**
     * Render menu item for dark theme
     */
    function renderDarkMenuItem(array $item, bool $isActive, bool $compact): string
    {
        $url = base_url($item['url']);
        $name = $item['name'];
        $icon = $item['icon'];

        $activeClass = $isActive ? 'text-blue-400 bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800';

        return <<<HTML
                <!-- {$name} -->
                <a href="{$url}"
                   class="nav-link flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 {$activeClass} mb-1 mx-2 rounded-md"
                   title="{$name}">
                    <i class="{$icon} w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span class="nav-text">{$name}</span>
                </a>

HTML;
    }
}
