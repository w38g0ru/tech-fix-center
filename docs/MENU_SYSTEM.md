# Menu System Documentation

## Overview
The TeknoPhix application uses a centralized, role-based menu system that dynamically shows/hides menu items based on user access levels stored in the session.

## Architecture

### Core Components

1. **MenuConfig.php** (`app/Config/MenuConfig.php`)
   - Central configuration for all menu items
   - Defines access levels and permissions
   - Contains menu structure and metadata

2. **menu_helper.php** (`app/Helpers/menu_helper.php`)
   - Renders menu HTML for different themes
   - Handles access level checking
   - Provides theme-specific styling

3. **session_helper.php** (`app/Helpers/session_helper.php`)
   - Manages user roles and access levels
   - Provides session-based authentication
   - Contains role hierarchy logic

## Access Levels

The system uses a hierarchical access level system:

| Level | Value | Description |
|-------|-------|-------------|
| `all` | - | Available to all users (including guests) |
| `user` | 1 | Regular users and above |
| `technician` | 2 | Technicians and above |
| `admin` | 3 | Admin users and above |
| `super_admin` | 4 | Super admin only |

Higher levels inherit access from lower levels (Admin can access everything a User can).

## Menu Structure

### Main Menu
- **Dashboard** - `all` access
- **Jobs** - `user` access
- **Customers** - `user` access

### Management Section
- **Inventory** - `user` access
- **Stock Management** - `technician` access
- **Reports** - `technician` access
- **Photoproof** - `user` access
- **Dispatch** - `technician` access
- **Parts Requests** - `user` access

### Administration Section
- **Service Centers** - `admin` access
- **Technicians** - `admin` access
- **User Management** - `admin` access

### User Section
- **Profile** - `all` access
- **Settings** - `admin` access

### Support Section
- **User Guide** - `all` access

## Usage

### Adding New Menu Items

1. Edit `app/Config/MenuConfig.php`
2. Add item to appropriate section:

```php
[
    'name' => 'New Feature',
    'url' => 'dashboard/new-feature',
    'icon' => 'fas fa-star',
    'color' => 'text-blue-600',
    'active_check' => ['new-feature'],
    'gradient' => 'from-blue-500 to-blue-600',
    'access_level' => 'user'
]
```

### Setting User Roles

```php
helper('session');
setUserRole('admin'); // Sets user as admin
```

### Checking Access Levels

```php
helper('session');

// Check specific access level
if (hasAccessLevel('admin')) {
    // Admin-only code
}

// Check if user is admin
if (isAdmin()) {
    // Admin code
}

// Check if user is technician or higher
if (isTechnician()) {
    // Technician+ code
}
```

### Rendering Menus

```php
helper('menu');

// Light theme, compact
echo renderMenuItems('light', true);

// Dark theme, compact
echo renderMenuItems('dark', true);
```

## Testing

Use the role switcher for testing different access levels:

1. Visit `/test/role-switcher`
2. Click role buttons to switch between access levels
3. Check sidebar menu changes
4. View access matrix

Available test URLs:
- `/test/role-switcher` - Role switching interface
- `/test/set-role/user` - Set user role
- `/test/set-role/technician` - Set technician role
- `/test/set-role/admin` - Set admin role
- `/test/set-role/guest` - Clear role (guest access)

## Customization

### Themes
The system supports two themes:
- **Light Theme** - Clean white sidebar with blue accents
- **Dark Theme** - Modern dark gradient with colorful menu items

### Styling
Menu items can be customized with:
- Icons (FontAwesome classes)
- Colors (Tailwind CSS classes)
- Gradients (for dark theme)
- Subtitles (for expanded view)

### Access Control
Access levels can be modified in `MenuConfig::hasAccessLevel()` method to implement custom logic or integrate with external authentication systems.

## Security Notes

1. **Session-Based**: Access control relies on session data
2. **Client-Side**: Menu visibility is cosmetic - server-side route protection still required
3. **Role Hierarchy**: Higher roles automatically inherit lower role permissions
4. **Fallback**: Unknown roles default to no access (guest level)

## Integration

The menu system integrates with:
- CodeIgniter 4 session management
- Tailwind CSS for styling
- FontAwesome for icons
- Dashboard layouts (both light and dark themes)

## Maintenance

To maintain the menu system:
1. Keep `MenuConfig.php` updated with new routes
2. Ensure access levels match business requirements
3. Test role switching after changes
4. Update documentation when adding new access levels
