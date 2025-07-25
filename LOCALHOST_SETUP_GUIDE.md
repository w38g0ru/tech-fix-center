# TeknoPhix Localhost Setup Guide

## 🚀 Quick Setup Steps

### 1. **Update Your Hosts File**
Add this line to your hosts file:
```
127.0.0.1 tfc.local
```

**Hosts file locations:**
- **Mac/Linux:** `/etc/hosts`
- **Windows:** `C:\Windows\System32\drivers\etc\hosts`

### 2. **Apache Virtual Host Configuration**
Use the configuration provided in `apache_vhost_config.txt` and add it to your Apache virtual hosts file.

### 3. **Database Setup**
Create the localhost database with the correct credentials:

**Option 1: Run the setup script**
```bash
mysql -u root -p < database_setup_localhost.sql
```

**Option 2: Manual setup**
```sql
-- Login to MySQL as root with password: Ab*2525125
mysql -u root -p

-- Create the database
CREATE DATABASE tfc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant permissions (if needed)
GRANT ALL PRIVILEGES ON tfc.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
```

**Database Configuration:**
- **Hostname:** localhost
- **Username:** root
- **Password:** Ab*2525125
- **Database:** tfc

### 4. **Test Your Setup**
Visit these URLs to verify everything is working:
- **Main Test:** http://tfc.local/test
- **Database Test:** http://tfc.local/test/database
- **Routes Test:** http://tfc.local/test/routes

## 🔧 Configuration Changes Made

### ✅ **Fixed Configuration Files:**

1. **`.env` file:**
   - Changed `app.baseURL` from `https://tfc.gaighat.com/` to `http://tfc.local/`
   - Updated database configuration for localhost:
     - `database.default.database = tfc`
     - `database.default.username = root`
     - `database.default.password = Ab*2525125`

2. **`app/Config/App.php`:**
   - Changed `$baseURL` from `https://tfc.gaighat.com/` to `http://tfc.local/`

3. **`app/Config/Database.php`:**
   - Added environment-specific database configuration
   - Automatically switches between localhost and production settings
   - Localhost uses: root/Ab*2525125/tfc
   - Production uses: tfcgaighat_db/[password]/tfcgaighat_db

3. **Added test routes** in `app/Config/Routes.php`

### ✅ **Created Test Files:**
- `app/Controllers/Test.php` - Test controller
- `app/Views/test_page.php` - Main test page
- `app/Views/test_database.php` - Database test page

## 🐛 Common Issues & Solutions

### **Issue 1: "Page Not Found" or 404 Error**
**Solutions:**
- Verify Apache virtual host is configured correctly
- Check that `tfc.local` is added to your hosts file
- Ensure Apache has been restarted after configuration changes
- Verify the document root path in virtual host matches your project location

### **Issue 2: Database Connection Failed**
**Solutions:**
- Make sure MySQL/MariaDB is running
- Create the database: `CREATE DATABASE tfc;`
- Set MySQL root password to: `Ab*2525125`
- Run the setup script: `mysql -u root -p < database_setup_localhost.sql`
- Verify MySQL credentials match:
  - Username: `root`
  - Password: `Ab*2525125`
  - Database: `tfc`
- Check if MySQL is running on port 3306

### **Issue 3: Apache Permission Denied**
**Solutions:**
- Check directory permissions: `chmod 755 /path/to/your/project`
- Ensure Apache user has read access to project files
- Verify `AllowOverride All` is set in virtual host configuration

### **Issue 4: .htaccess Not Working**
**Solutions:**
- Enable mod_rewrite: `sudo a2enmod rewrite` (Linux)
- Restart Apache after enabling mod_rewrite
- Check that `AllowOverride All` is set in virtual host

### **Issue 5: PHP Errors or White Screen**
**Solutions:**
- Check PHP error logs
- Ensure PHP version is 7.4 or higher
- Verify all required PHP extensions are installed
- Check file permissions

## 📋 **Required PHP Extensions**
Make sure these PHP extensions are installed:
- `php-mysqli` or `php-pdo-mysql`
- `php-mbstring`
- `php-json`
- `php-xml`
- `php-curl`
- `php-gd` (for image handling)
- `php-zip`

## 🔍 **Verification Steps**

### **Step 1: Basic Setup Test**
Visit: http://tfc.local/test
- Should show system information
- Green success message
- System details (PHP version, CI version, etc.)

### **Step 2: Database Connection Test**
Visit: http://tfc.local/test/database
- Should show "Database Connection Successful!" if working
- If failed, shows troubleshooting tips

### **Step 3: Application Access**
Visit: http://tfc.local/
- Should redirect to login page
- If you see the login form, everything is working!

## 🛠️ **XAMPP/MAMP Users**

### **For XAMPP:**
1. Place project in `C:\xampp\htdocs\tfc` (Windows) or `/Applications/XAMPP/xamppfiles/htdocs/tfc` (Mac)
2. Add virtual host configuration to `httpd-vhosts.conf`
3. Uncomment virtual hosts include line in `httpd.conf`
4. Add to hosts file: `127.0.0.1 tfc.local`
5. Restart XAMPP

### **For MAMP:**
1. Place project in `/Applications/MAMP/htdocs/tfc`
2. Configure virtual host in MAMP settings
3. Add to hosts file: `127.0.0.1 tfc.local`
4. Restart MAMP

## 📞 **Still Having Issues?**

If you're still experiencing problems:

1. **Check Apache Error Logs:**
   - Look for error messages in Apache error logs
   - Common location: `/var/log/apache2/error.log`

2. **Check PHP Error Logs:**
   - Enable error reporting in development
   - Check PHP error logs for detailed error messages

3. **Verify File Permissions:**
   - Ensure web server can read all project files
   - Check that writable directories have proper permissions

4. **Test with Simple PHP File:**
   - Create a simple `info.php` file with `<?php phpinfo(); ?>`
   - Place it in your document root and access via browser

## 🎯 **Next Steps After Setup**

Once your localhost is working:
1. Visit http://tfc.local/ to access the application
2. Use the login system to access the dashboard
3. Explore the professional view layouts we created
4. Test the API endpoints if needed

Your TeknoPhix application should now be running smoothly on your local Apache server! 🚀
