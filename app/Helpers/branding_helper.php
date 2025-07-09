<?php

/**
 * Branding Helper
 * 
 * Provides easy access to application branding and configuration
 * throughout the Tech Fix Center application
 */

if (!function_exists('getAppConfig')) {
    /**
     * Get application configuration instance
     */
    function getAppConfig()
    {
        return config('App');
    }
}

if (!function_exists('getAppName')) {
    /**
     * Get application name
     */
    function getAppName($short = false)
    {
        $config = getAppConfig();
        return $short ? $config->appShortName : $config->appName;
    }
}

if (!function_exists('getAppVersion')) {
    /**
     * Get application version
     */
    function getAppVersion()
    {
        return getAppConfig()->appVersion;
    }
}

if (!function_exists('getCompanyInfo')) {
    /**
     * Get company information
     */
    function getCompanyInfo($key = null)
    {
        $config = getAppConfig();
        $info = [
            'name' => $config->companyName,
            'tagline' => $config->companyTagline,
            'website' => $config->companyWebsite,
            'email' => $config->supportEmail,
            'phone' => $config->contactPhone,
            'address' => $config->companyAddress,
            'description' => $config->appDescription
        ];
        
        return $key ? ($info[$key] ?? null) : $info;
    }
}

if (!function_exists('getBrandColor')) {
    /**
     * Get brand color by name
     */
    function getBrandColor($colorName = 'primary')
    {
        $colors = getAppConfig()->brandColors;
        return $colors[$colorName] ?? $colors['primary'];
    }
}

if (!function_exists('getAllBrandColors')) {
    /**
     * Get all brand colors
     */
    function getAllBrandColors()
    {
        return getAppConfig()->brandColors;
    }
}

if (!function_exists('getSocialMedia')) {
    /**
     * Get social media links
     */
    function getSocialMedia($platform = null)
    {
        $social = getAppConfig()->socialMedia;
        return $platform ? ($social[$platform] ?? null) : $social;
    }
}

if (!function_exists('getAppTitle')) {
    /**
     * Generate page title with app branding
     */
    function getAppTitle($pageTitle = null)
    {
        $appName = getAppName();
        return $pageTitle ? "{$pageTitle} - {$appName}" : $appName;
    }
}

if (!function_exists('getAppMeta')) {
    /**
     * Get application meta information for HTML head
     */
    function getAppMeta()
    {
        $config = getAppConfig();
        return [
            'title' => $config->appName,
            'description' => $config->appDescription,
            'keywords' => 'device repair, tech fix, mobile repair, laptop repair, electronics service',
            'author' => $config->companyName,
            'viewport' => 'width=device-width, initial-scale=1.0',
            'robots' => 'index, follow',
            'og:title' => $config->appName,
            'og:description' => $config->appDescription,
            'og:type' => 'website',
            'og:url' => $config->baseURL,
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $config->appName,
            'twitter:description' => $config->appDescription
        ];
    }
}

if (!function_exists('renderBrandLogo')) {
    /**
     * Render brand logo HTML
     */
    function renderBrandLogo($size = 'md', $showText = true, $classes = '')
    {
        $sizes = [
            'xs' => 'h-6 w-6',
            'sm' => 'h-8 w-8', 
            'md' => 'h-10 w-10',
            'lg' => 'h-12 w-12',
            'xl' => 'h-16 w-16'
        ];
        
        $sizeClass = $sizes[$size] ?? $sizes['md'];
        $appName = getAppName();
        $shortName = getAppName(true);
        
        $logo = '<div class="flex items-center ' . $classes . '">';
        
        // Logo icon (using a tech/repair themed icon)
        $logo .= '<div class="' . $sizeClass . ' bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">';
        $logo .= '<i class="fas fa-tools text-lg"></i>';
        $logo .= '</div>';
        
        // App name text
        if ($showText) {
            $logo .= '<div class="ml-3">';
            $logo .= '<div class="text-lg font-bold text-gray-900">' . $appName . '</div>';
            $logo .= '<div class="text-xs text-gray-500">' . getCompanyInfo('tagline') . '</div>';
            $logo .= '</div>';
        }
        
        $logo .= '</div>';
        
        return $logo;
    }
}

if (!function_exists('renderFooterBranding')) {
    /**
     * Render footer branding information
     */
    function renderFooterBranding()
    {
        $company = getCompanyInfo();
        $social = getSocialMedia();
        $currentYear = date('Y');
        
        $footer = '<div class="bg-gray-800 text-white py-8">';
        $footer .= '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';
        $footer .= '<div class="grid grid-cols-1 md:grid-cols-3 gap-8">';
        
        // Company Info
        $footer .= '<div>';
        $footer .= '<h3 class="text-lg font-semibold mb-4">' . $company['name'] . '</h3>';
        $footer .= '<p class="text-gray-300 mb-2">' . $company['description'] . '</p>';
        $footer .= '<p class="text-gray-400 text-sm">' . $company['address'] . '</p>';
        $footer .= '</div>';
        
        // Contact Info
        $footer .= '<div>';
        $footer .= '<h3 class="text-lg font-semibold mb-4">Contact Us</h3>';
        $footer .= '<p class="text-gray-300 mb-2"><i class="fas fa-envelope mr-2"></i>' . $company['email'] . '</p>';
        $footer .= '<p class="text-gray-300 mb-2"><i class="fas fa-phone mr-2"></i>' . $company['phone'] . '</p>';
        $footer .= '<p class="text-gray-300"><i class="fas fa-globe mr-2"></i>' . $company['website'] . '</p>';
        $footer .= '</div>';
        
        // Social Media
        $footer .= '<div>';
        $footer .= '<h3 class="text-lg font-semibold mb-4">Follow Us</h3>';
        $footer .= '<div class="flex space-x-4">';
        foreach ($social as $platform => $url) {
            $icon = match($platform) {
                'facebook' => 'fab fa-facebook-f',
                'twitter' => 'fab fa-twitter',
                'instagram' => 'fab fa-instagram',
                'linkedin' => 'fab fa-linkedin-in',
                default => 'fas fa-link'
            };
            $footer .= '<a href="' . $url . '" class="text-gray-400 hover:text-white transition-colors" target="_blank">';
            $footer .= '<i class="' . $icon . ' text-xl"></i>';
            $footer .= '</a>';
        }
        $footer .= '</div>';
        $footer .= '</div>';
        
        $footer .= '</div>';
        
        // Copyright
        $footer .= '<div class="border-t border-gray-700 mt-8 pt-8 text-center">';
        $footer .= '<p class="text-gray-400">&copy; ' . $currentYear . ' ' . $company['name'] . '. All rights reserved.</p>';
        $footer .= '<p class="text-gray-500 text-sm mt-2">Version ' . getAppVersion() . '</p>';
        $footer .= '</div>';
        
        $footer .= '</div>';
        $footer .= '</div>';
        
        return $footer;
    }
}
