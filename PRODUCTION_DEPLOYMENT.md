# TFC Production Deployment Guide

## 🚨 Current Issue: https://tfc.gaighat.com/dashboard/jobs not working

### **Root Cause Analysis:**
The production site is redirecting to login (302) which means:
1. ✅ Server is accessible
2. ✅ CodeIgniter is running
3. ✅ Authentication system is working
4. ❌ Database connection or configuration issue

## 🔧 **Immediate Fixes Required:**

### **1. Database Configuration**
Update `.env` file on production server with correct database credentials:

```env
CI_ENVIRONMENT = production
app.baseURL = 'https://tfc.gaighat.com/'

# Update these with your actual production database credentials
database.default.hostname = [YOUR_DB_HOST]
database.default.database = [YOUR_DB_NAME] 
database.default.username = [YOUR_DB_USER]
database.default.password = [YOUR_DB_PASSWORD]
```

### **2. Database Setup**
Ensure the production database has all required tables:

```sql
-- Import the database structure
mysql -u [username] -p [database_name] < app/Models/tfc_database_dump.sql
```

### **3. File Permissions**
Set correct permissions on production server:

```bash
# Make writable directories
chmod -R 755 writable/
chmod -R 755 public/
chmod 644 .env

# Ensure Apache/Nginx can read files
chown -R www-data:www-data /path/to/tfc/
```

### **4. Apache/Nginx Configuration**
Ensure URL rewriting is enabled and document root points to `public/` folder.

**Apache (.htaccess should be in public/ folder):**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

**Nginx:**
```nginx
location / {
    try_files $uri $uri/ /index.php$is_args$args;
}
```

## 🔍 **Debugging Steps:**

### **Step 1: Check Database Connection**
Create a test file to verify database connection:

```php
<?php
// test_db.php - Upload to production server temporarily
require_once 'vendor/autoload.php';

$config = [
    'hostname' => 'your_db_host',
    'username' => 'your_db_user', 
    'password' => 'your_db_password',
    'database' => 'your_db_name'
];

try {
    $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    echo "✅ Database connection successful!";
    
    // Test if tables exist
    $result = $mysqli->query("SHOW TABLES LIKE 'admin_users'");
    if ($result->num_rows > 0) {
        echo "\n✅ Tables exist!";
    } else {
        echo "\n❌ Tables missing - need to import database!";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage();
}
?>
```

### **Step 2: Check Error Logs**
Look at server error logs:
```bash
# Apache
tail -f /var/log/apache2/error.log

# Nginx  
tail -f /var/log/nginx/error.log

# PHP
tail -f /var/log/php/error.log
```

### **Step 3: Enable CodeIgniter Debug Mode**
Temporarily set in `.env`:
```env
CI_ENVIRONMENT = development
```

## 📋 **Production Deployment Checklist:**

- [ ] **Database Setup**
  - [ ] Create production database
  - [ ] Import database structure from `app/Models/tfc_database_dump.sql`
  - [ ] Create database user with proper permissions
  - [ ] Test database connection

- [ ] **Environment Configuration**
  - [ ] Copy `.env.production` to `.env` on server
  - [ ] Update database credentials
  - [ ] Set secure encryption key
  - [ ] Configure proper base URL

- [ ] **File Permissions**
  - [ ] Set writable permissions on `writable/` folder
  - [ ] Set proper ownership (www-data or apache user)
  - [ ] Secure `.env` file permissions (644)

- [ ] **Web Server Configuration**
  - [ ] Document root points to `public/` folder
  - [ ] URL rewriting enabled
  - [ ] HTTPS properly configured
  - [ ] PHP extensions installed (mysqli, mbstring, etc.)

- [ ] **Security**
  - [ ] HTTPS enforced
  - [ ] Secure headers configured
  - [ ] Database credentials secured
  - [ ] Remove any test files

- [ ] **Testing**
  - [ ] Login page accessible
  - [ ] Database connection working
  - [ ] Authentication working
  - [ ] All dashboard routes accessible after login

## 🚀 **Quick Fix Commands:**

```bash
# 1. Update .env with production settings
cp .env.production .env
nano .env  # Edit with your actual credentials

# 2. Import database
mysql -u [user] -p [database] < app/Models/tfc_database_dump.sql

# 3. Set permissions
chmod -R 755 writable/
chown -R www-data:www-data ./

# 4. Test the site
curl -I https://tfc.gaighat.com/auth/login
```

## 📞 **Need Help?**
If issues persist, check:
1. Server error logs
2. Database connection
3. PHP version compatibility (requires PHP 8.1+)
4. Required PHP extensions installed
