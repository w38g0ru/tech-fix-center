# TeknoPhix - Advanced Technology Repair Management System

## About TeknoPhix

TeknoPhix is a comprehensive technology repair management system designed for modern repair shops and service centers. Built with CodeIgniter 4, it provides a professional solution for managing device repairs, inventory, technicians, and customer relationships.

### Key Features

- **Device Repair Management**: Complete job tracking from intake to completion
- **Inventory Management**: Track parts, stock levels, and movements
- **Technician Management**: Assign jobs and track technician performance
- **Customer Management**: Handle walk-in customers and referred jobs
- **Photo Documentation**: Visual proof of repairs and device conditions
- **Service Center Integration**: Manage multiple service locations
- **Responsive Design**: Works seamlessly on desktop and mobile devices

## Installation

### Requirements
- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache/Nginx web server
- Composer

### Quick Setup
1. Clone the repository
2. Run `composer install`
3. Copy `env` to `.env` and configure:
   - Database settings
   - Base URL (http://teknophix.local/ for local development)
   - Environment settings
4. Import the database schema
5. Configure your web server to point to the `public` directory

### Default Login
- **Email**: admin@teknophix.com
- **Password**: password

## System Modules

### Core Features
- **Dashboard**: Overview of repair jobs, inventory, and system status
- **Job Management**: Create, track, and manage repair jobs
- **Inventory Control**: Parts management with stock tracking
- **Technician Portal**: Assign and track technician work
- **Customer Management**: Handle walk-in and referred customers
- **Photo Documentation**: Upload and manage repair photos
- **Service Centers**: Multi-location support
- **User Management**: Role-based access control

### Technology Stack
- **Backend**: CodeIgniter 4 (PHP Framework)
- **Frontend**: Vanilla JavaScript, CSS3, HTML5
- **Styling**: Tailwind CSS
- **Database**: MySQL/MariaDB
- **Icons**: Font Awesome

## Configuration

### Web Server Setup
Configure your web server to point to the `public` folder for security:
- **Apache**: Use virtual hosts pointing to `/path/to/teknophix/public`
- **Nginx**: Set document root to `/path/to/teknophix/public`

### Environment Variables
Key settings in your `.env` file:
```
app.baseURL = 'http://teknophix.local/'
database.default.hostname = localhost
database.default.database = teknophix_db
database.default.username = your_username
database.default.password = your_password
```

## Support

For support and feature requests, please contact:
- **Email**: support@teknophix.com
- **Website**: https://teknophix.gaighat.com

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

**TeknoPhix** - Precision Technology Solutions
