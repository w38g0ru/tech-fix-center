# AdminLTE-Style Dashboard for CodeIgniter 4

A clean, responsive admin dashboard built with **CodeIgniter 4**, **Tailwind CSS**, and modern web technologies. Inspired by AdminLTE design patterns with a focus on usability, performance, and mobile responsiveness.

## 🚀 Features

### ✨ Core Features
- **Responsive Design**: Mobile-first approach with perfect tablet and desktop layouts
- **Dark Mode**: Complete dark/light theme with localStorage persistence
- **Modern UI**: Clean, professional interface inspired by AdminLTE
- **Tailwind CSS**: Utility-first CSS framework for rapid development
- **Chart.js Integration**: Beautiful, interactive charts and graphs
- **DataTables**: Advanced table functionality with search, sort, and pagination

### 🔐 Authentication & Security
- Role-based access control (Admin, Manager, User)
- Secure password hashing
- Session management
- CSRF protection
- Input validation and sanitization

### 📊 Dashboard Components
- **Statistics Cards**: Key metrics with trend indicators
- **Interactive Charts**: Sales overview and user growth charts
- **Recent Activity**: Real-time activity feed
- **Quick Actions**: Shortcut buttons for common tasks
- **User Management**: Complete CRUD operations for users

### 📱 Mobile Features
- Touch-friendly interface
- Collapsible sidebar navigation
- Mobile-optimized tables
- Responsive modals and forms
- Swipe gestures support

## 🛠️ Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache/Nginx)

### Step 1: Clone or Download
```bash
# If using Git
git clone <repository-url>
cd admin-dashboard

# Or download and extract the files
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp env .env

# Edit .env file with your database credentials
```

**Configure your `.env` file:**
```env
# Database
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi

# Base URL
app.baseURL = 'http://localhost:8080/'

# Environment
CI_ENVIRONMENT = development
```

### Step 4: Database Setup
```bash
# Run migrations
php spark migrate

# The migration will create the users table and insert sample data
```

### Step 5: Configure Routes
Add the admin routes to your `app/Config/Routes.php`:

```php
// Include admin routes
require_once APPPATH . 'Config/AdminRoutes.php';
```

### Step 6: Start Development Server
```bash
php spark serve
```

Visit `http://localhost:8080/admin` to access the dashboard.

## 🔑 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | admin123 |
| Manager | manager@example.com | manager123 |
| User | user@example.com | user123 |

## 📁 Project Structure

```
app/
├── Controllers/
│   └── Admin/
│       ├── Dashboard.php      # Main dashboard controller
│       └── Users.php          # User management controller
├── Models/
│   └── UserModel.php          # User data model
├── Views/
│   ├── layouts/
│   │   └── admin.php          # Main admin layout
│   ├── admin/
│   │   ├── dashboard.php      # Dashboard home page
│   │   └── users/
│   │       └── index.php      # User management page
│   └── partials/
│       └── admin/
│           ├── sidebar.php    # Navigation sidebar
│           ├── navbar.php     # Top navigation
│           ├── breadcrumb.php # Breadcrumb navigation
│           ├── flash_messages.php # Alert messages
│           └── dark_mode.php  # Dark mode component
├── Database/
│   └── Migrations/
│       └── 2024-01-01-000001_CreateUsersTable.php
└── Config/
    └── AdminRoutes.php        # Admin route definitions

public/
└── admin-assets/
    └── css/
        └── responsive.css     # Mobile responsive styles
```

## 🎨 Customization

### Changing Colors
Edit the Tailwind configuration in `app/Views/layouts/admin.php`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    500: '#3b82f6',  // Change this to your brand color
                    600: '#2563eb',
                    700: '#1d4ed8',
                }
            }
        }
    }
}
```

### Adding New Menu Items
Edit `app/Views/partials/admin/sidebar.php` to add navigation items:

```php
<li>
    <a href="<?= base_url('admin/your-module') ?>" 
       class="nav-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg">
        <i class="fas fa-your-icon w-5 h-5 mr-3"></i>
        <span class="font-medium">Your Module</span>
    </a>
</li>
```

### Creating New Controllers
Follow the existing pattern in `app/Controllers/Admin/`:

```php
<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class YourController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Your Page Title',
            'breadcrumb' => [
                ['title' => 'Your Module', 'icon' => 'fas fa-your-icon']
            ]
        ];
        
        return view('admin/your-module/index', $data);
    }
}
```

## 📊 Chart Integration

The dashboard uses Chart.js for data visualization. To add new charts:

```javascript
// In your view file
const ctx = document.getElementById('yourChart').getContext('2d');
new Chart(ctx, {
    type: 'line', // or 'bar', 'pie', 'doughnut'
    data: {
        labels: ['Jan', 'Feb', 'Mar'],
        datasets: [{
            label: 'Your Data',
            data: [12, 19, 3],
            borderColor: '#3b82f6',
            backgroundColor: '#3b82f620'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
```

## 🔒 Security Features

- **CSRF Protection**: Enabled by default
- **Input Validation**: Server-side validation for all forms
- **Password Hashing**: Secure password storage
- **Role-based Access**: Middleware for route protection
- **SQL Injection Prevention**: Using CodeIgniter's Query Builder

## 📱 Mobile Responsiveness

The dashboard is fully responsive with:
- Mobile-first design approach
- Touch-friendly interface elements
- Collapsible navigation
- Responsive tables and forms
- Optimized for all screen sizes

## 🌙 Dark Mode

Dark mode features:
- System preference detection
- localStorage persistence
- Smooth transitions
- Chart theme updates
- Keyboard shortcut (Ctrl/Cmd + Shift + D)

## 🚀 Performance

- **Lazy Loading**: Components load as needed
- **Optimized Assets**: Minified CSS and JS
- **Efficient Queries**: Optimized database operations
- **Caching**: Built-in CodeIgniter caching
- **CDN Assets**: External libraries from CDN

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🆘 Support

For support and questions:
- Check the documentation
- Review existing issues
- Create a new issue with detailed information

## 🔄 Updates

Stay updated with the latest features and security patches by regularly checking for updates.

---

**Built with ❤️ using CodeIgniter 4 and Tailwind CSS**
