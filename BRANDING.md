# Tech Fix Center - Branding Guide

## Overview
This document outlines the comprehensive branding system implemented for the Tech Fix Center application, including brand colors, typography, logos, and usage guidelines.

## Brand Identity

### Company Information
- **Name**: Tech Fix Center
- **Short Name**: TFC
- **Version**: 2.0.0
- **Tagline**: Expert Device Repair Solutions
- **Description**: Professional Device Repair Management System

### Contact Information
- **Email**: support@techfixcenter.com
- **Phone**: +977-1-4567890
- **Address**: Gaighat, Udayapur, Nepal
- **Website**: https://tfc.gaighat.com

## Brand Colors

### Primary Color Palette
```css
Primary:    #2563eb (Blue-600)
Secondary:  #7c3aed (Violet-600)
Accent:     #059669 (Emerald-600)
Warning:    #d97706 (Amber-600)
Danger:     #dc2626 (Red-600)
Success:    #16a34a (Green-600)
Info:       #0891b2 (Cyan-600)
Dark:       #1f2937 (Gray-800)
Light:      #f9fafb (Gray-50)
```

### Usage Guidelines
- **Primary**: Main brand color for buttons, links, and primary elements
- **Secondary**: Accent color for gradients and secondary elements
- **Accent**: Success states and positive actions
- **Warning**: Caution states and pending actions
- **Danger**: Error states and destructive actions

## Typography

### Font Family
- **Primary**: Inter, system-ui, sans-serif
- **Fallback**: System fonts for optimal performance

### Font Weights
- **Light**: 300
- **Regular**: 400
- **Medium**: 500
- **Semibold**: 600
- **Bold**: 700

## Logo & Visual Identity

### Logo Components
- **Icon**: Tools icon (fas fa-tools) representing repair services
- **Background**: Gradient from primary to secondary color
- **Shape**: Rounded square/circle for modern appearance
- **Text**: Company name with tagline

### Logo Variations
- **Full Logo**: Icon + Company Name + Tagline
- **Compact**: Icon + Short Name (TFC)
- **Icon Only**: Just the tools icon for small spaces

## Branding Helper Functions

### Basic Functions
```php
// Get application name
getAppName()           // Returns: "Tech Fix Center"
getAppName(true)       // Returns: "TFC"

// Get application version
getAppVersion()        // Returns: "2.0.0"

// Get company information
getCompanyInfo()       // Returns: Array of all company info
getCompanyInfo('name') // Returns: "Tech Fix Center"
getCompanyInfo('email') // Returns: "support@techfixcenter.com"
```

### Color Functions
```php
// Get brand colors
getBrandColor()              // Returns: "#2563eb" (primary)
getBrandColor('secondary')   // Returns: "#7c3aed"
getAllBrandColors()          // Returns: Array of all colors
```

### UI Components
```php
// Generate page titles
getAppTitle()                // Returns: "Tech Fix Center"
getAppTitle('Dashboard')     // Returns: "Dashboard - Tech Fix Center"

// Render logo
renderBrandLogo()            // Full logo with text
renderBrandLogo('sm', false) // Small icon only
```

## CSS Classes

### Custom Brand Classes
```css
.brand-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
}

.brand-shadow {
    box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.15);
}

.brand-text-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
```

### Tailwind Brand Colors
```css
/* Use in Tailwind classes */
bg-brand-primary
text-brand-secondary
border-brand-accent
```

## Implementation Examples

### Page Header
```php
<?php helper('branding'); ?>
<title><?= getAppTitle($pageTitle) ?></title>
<meta name="description" content="<?= getAppMeta()['description'] ?>">
```

### Logo in Navigation
```php
<div class="brand-gradient p-4">
    <?= renderBrandLogo('md', true) ?>
</div>
```

### Branded Button
```html
<button class="bg-brand-primary hover:bg-brand-secondary text-white px-4 py-2 rounded-lg brand-shadow">
    Action Button
</button>
```

## Social Media

### Platforms
- **Facebook**: https://facebook.com/techfixcenter
- **Twitter**: https://twitter.com/techfixcenter
- **Instagram**: https://instagram.com/techfixcenter
- **LinkedIn**: https://linkedin.com/company/techfixcenter

### Usage
```php
$social = getSocialMedia();
$facebook = getSocialMedia('facebook');
```

## SEO & Meta Tags

### Automatic Meta Generation
The branding system automatically generates:
- Page titles with brand consistency
- Meta descriptions
- Open Graph tags
- Twitter Card tags
- Favicon references

### Usage
```php
$meta = getAppMeta();
// Automatically includes all necessary meta information
```

## File Structure

```
app/
├── Config/App.php              # Main branding configuration
├── Helpers/branding_helper.php # Branding utility functions
└── Views/
    ├── layouts/dashboard.php   # Branded dashboard layout
    └── auth/login.php         # Branded login page

public/
├── favicon.ico                # Application favicon
└── favicon.svg               # SVG favicon
```

## Best Practices

### Do's
- ✅ Use helper functions for consistent branding
- ✅ Apply brand colors consistently
- ✅ Include proper meta tags on all pages
- ✅ Use the logo components appropriately
- ✅ Maintain color contrast for accessibility

### Don'ts
- ❌ Hard-code brand information in views
- ❌ Use colors outside the brand palette
- ❌ Modify logo proportions or colors
- ❌ Skip meta tag implementation
- ❌ Use inconsistent typography

## Customization

To modify branding:
1. Update `app/Config/App.php` with new brand information
2. Modify color values in the brand colors array
3. Update company information as needed
4. The changes will automatically apply throughout the application

## Support

For branding questions or modifications, contact the development team or refer to the application documentation.
