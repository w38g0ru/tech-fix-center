<?php
/**
 * Dark Mode Component
 * 
 * Provides dark mode toggle functionality with localStorage persistence
 * and smooth transitions between light and dark themes.
 */
?>

<!-- Dark Mode Styles -->
<style>
    /* Dark mode color variables */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-tertiary: #9ca3af;
        --border-primary: #e5e7eb;
        --border-secondary: #d1d5db;
        --shadow-primary: rgba(0, 0, 0, 0.1);
        --shadow-secondary: rgba(0, 0, 0, 0.05);
    }
    
    .dark {
        --bg-primary: #1f2937;
        --bg-secondary: #111827;
        --bg-tertiary: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #d1d5db;
        --text-tertiary: #9ca3af;
        --border-primary: #374151;
        --border-secondary: #4b5563;
        --shadow-primary: rgba(0, 0, 0, 0.3);
        --shadow-secondary: rgba(0, 0, 0, 0.2);
    }
    
    /* Smooth transitions for theme switching */
    * {
        transition: background-color 0.2s ease-in-out, 
                   border-color 0.2s ease-in-out, 
                   color 0.2s ease-in-out,
                   box-shadow 0.2s ease-in-out;
    }
    
    /* Dark mode toggle button styles */
    .dark-mode-toggle {
        position: relative;
        width: 60px;
        height: 30px;
        background: #e5e7eb;
        border-radius: 15px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border: none;
        outline: none;
    }
    
    .dark-mode-toggle:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }
    
    .dark-mode-toggle.active {
        background: #3b82f6;
    }
    
    .dark-mode-toggle::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 24px;
        height: 24px;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .dark-mode-toggle.active::before {
        transform: translateX(30px);
    }
    
    /* Dark mode toggle icons */
    .dark-mode-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        transition: opacity 0.3s ease;
    }
    
    .dark-mode-icon.sun {
        left: 8px;
        color: #fbbf24;
        opacity: 1;
    }
    
    .dark-mode-icon.moon {
        right: 8px;
        color: #e5e7eb;
        opacity: 0.5;
    }
    
    .dark-mode-toggle.active .dark-mode-icon.sun {
        opacity: 0.5;
    }
    
    .dark-mode-toggle.active .dark-mode-icon.moon {
        opacity: 1;
        color: #ffffff;
    }
    
    /* Custom scrollbar for dark mode */
    .dark .scrollbar-thin::-webkit-scrollbar-track {
        background: #374151;
    }
    
    .dark .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #6b7280;
    }
    
    .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    
    /* Dark mode chart adjustments */
    .dark .chart-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-primary);
    }
    
    /* Dark mode form elements */
    .dark input[type="text"],
    .dark input[type="email"],
    .dark input[type="password"],
    .dark input[type="number"],
    .dark select,
    .dark textarea {
        background: var(--bg-tertiary);
        border-color: var(--border-primary);
        color: var(--text-primary);
    }
    
    .dark input[type="text"]:focus,
    .dark input[type="email"]:focus,
    .dark input[type="password"]:focus,
    .dark input[type="number"]:focus,
    .dark select:focus,
    .dark textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }
    
    /* Dark mode table styles */
    .dark table {
        background: var(--bg-primary);
    }
    
    .dark thead {
        background: var(--bg-tertiary);
    }
    
    .dark tbody tr:hover {
        background: var(--bg-secondary);
    }
    
    /* Dark mode modal styles */
    .dark .modal {
        background: var(--bg-primary);
        border: 1px solid var(--border-primary);
    }
    
    .dark .modal-overlay {
        background: rgba(0, 0, 0, 0.7);
    }
    
    /* Dark mode dropdown styles */
    .dark .dropdown-menu {
        background: var(--bg-primary);
        border: 1px solid var(--border-primary);
        box-shadow: 0 10px 25px var(--shadow-primary);
    }
    
    /* Dark mode button variants */
    .dark .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border-color: var(--border-primary);
    }
    
    .dark .btn-secondary:hover {
        background: var(--bg-secondary);
    }
    
    /* Dark mode alert styles */
    .dark .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
        color: #93c5fd;
    }
    
    .dark .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border-color: rgba(34, 197, 94, 0.3);
        color: #86efac;
    }
    
    .dark .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        border-color: rgba(245, 158, 11, 0.3);
        color: #fcd34d;
    }
    
    .dark .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.3);
        color: #fca5a5;
    }
</style>

<!-- Dark Mode Toggle Component -->
<div class="flex items-center space-x-3">
    <span class="text-sm text-gray-600 dark:text-gray-400">Light</span>
    <button id="darkModeToggle" 
            class="dark-mode-toggle" 
            aria-label="Toggle dark mode"
            title="Toggle dark mode">
        <i class="fas fa-sun dark-mode-icon sun"></i>
        <i class="fas fa-moon dark-mode-icon moon"></i>
    </button>
    <span class="text-sm text-gray-600 dark:text-gray-400">Dark</span>
</div>

<script>
    /**
     * Dark Mode Manager
     * 
     * Handles dark mode toggle functionality with localStorage persistence
     * and system preference detection.
     */
    class DarkModeManager {
        constructor() {
            this.toggle = document.getElementById('darkModeToggle');
            this.init();
        }
        
        init() {
            // Check for saved theme preference or default to system preference
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                this.enableDarkMode();
            } else {
                this.enableLightMode();
            }
            
            // Listen for toggle clicks
            this.toggle.addEventListener('click', () => this.toggleTheme());
            
            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    if (e.matches) {
                        this.enableDarkMode();
                    } else {
                        this.enableLightMode();
                    }
                }
            });
            
            // Listen for keyboard shortcuts (Ctrl/Cmd + Shift + D)
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'D') {
                    e.preventDefault();
                    this.toggleTheme();
                }
            });
        }
        
        enableDarkMode() {
            document.documentElement.classList.add('dark');
            this.toggle.classList.add('active');
            localStorage.setItem('theme', 'dark');
            this.updateCharts();
            this.dispatchThemeChange('dark');
        }
        
        enableLightMode() {
            document.documentElement.classList.remove('dark');
            this.toggle.classList.remove('active');
            localStorage.setItem('theme', 'light');
            this.updateCharts();
            this.dispatchThemeChange('light');
        }
        
        toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                this.enableLightMode();
            } else {
                this.enableDarkMode();
            }
        }
        
        updateCharts() {
            // Update Chart.js charts if they exist
            if (typeof Chart !== 'undefined') {
                Chart.helpers.each(Chart.instances, (instance) => {
                    const isDark = document.documentElement.classList.contains('dark');
                    const textColor = isDark ? '#f3f4f6' : '#374151';
                    const gridColor = isDark ? '#374151' : '#e5e7eb';
                    
                    // Update chart options
                    if (instance.options.scales) {
                        Object.keys(instance.options.scales).forEach(scaleKey => {
                            const scale = instance.options.scales[scaleKey];
                            if (scale.grid) {
                                scale.grid.color = gridColor;
                            }
                            if (scale.ticks) {
                                scale.ticks.color = textColor;
                            }
                        });
                    }
                    
                    // Update the chart
                    instance.update();
                });
            }
        }
        
        dispatchThemeChange(theme) {
            // Dispatch custom event for other components to listen to
            const event = new CustomEvent('themeChanged', {
                detail: { theme }
            });
            document.dispatchEvent(event);
        }
        
        getCurrentTheme() {
            return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }
    }
    
    // Initialize dark mode manager when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        window.darkModeManager = new DarkModeManager();
    });
    
    // Export for use in other scripts
    window.DarkModeManager = DarkModeManager;
</script>
