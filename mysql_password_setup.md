# MySQL Root Password Setup Guide

## 🔐 Setting MySQL Root Password to: Ab*2525125

### **Method 1: Using MySQL Command Line (Recommended)**

1. **Stop MySQL service:**
   ```bash
   # On Mac with Homebrew
   brew services stop mysql
   
   # On Ubuntu/Linux
   sudo systemctl stop mysql
   
   # On Windows (Command Prompt as Administrator)
   net stop mysql
   ```

2. **Start MySQL in safe mode:**
   ```bash
   # On Mac/Linux
   sudo mysqld_safe --skip-grant-tables &
   
   # On Windows
   mysqld --skip-grant-tables
   ```

3. **Connect to MySQL (no password needed):**
   ```bash
   mysql -u root
   ```

4. **Set the new password:**
   ```sql
   USE mysql;
   UPDATE user SET authentication_string = PASSWORD('Ab*2525125') WHERE User = 'root';
   FLUSH PRIVILEGES;
   EXIT;
   ```

5. **Restart MySQL normally:**
   ```bash
   # On Mac with Homebrew
   brew services restart mysql
   
   # On Ubuntu/Linux
   sudo systemctl restart mysql
   
   # On Windows
   net start mysql
   ```

6. **Test the connection:**
   ```bash
   mysql -u root -p
   # Enter password: Ab*2525125
   ```

### **Method 2: Using XAMPP/MAMP**

#### **For XAMPP:**
1. Open XAMPP Control Panel
2. Click "Admin" next to MySQL (opens phpMyAdmin)
3. Go to "User accounts" tab
4. Click "Edit privileges" for root user
5. Click "Change password"
6. Enter: `Ab*2525125`
7. Click "Go"

#### **For MAMP:**
1. Open MAMP
2. Click "WebStart" to open MAMP start page
3. Go to "Tools" → "phpMyAdmin"
4. Click "User accounts" tab
5. Click "Edit privileges" for root user
6. Click "Change password"
7. Enter: `Ab*2525125`
8. Click "Go"

### **Method 3: Reset MySQL Password (If you forgot current password)**

#### **On Mac:**
```bash
# Stop MySQL
sudo /usr/local/mysql/support-files/mysql.server stop

# Start MySQL in safe mode
sudo mysqld_safe --skip-grant-tables

# In another terminal
mysql -u root

# Set password
USE mysql;
UPDATE user SET authentication_string = PASSWORD('Ab*2525125') WHERE User = 'root';
FLUSH PRIVILEGES;
EXIT;

# Restart MySQL
sudo /usr/local/mysql/support-files/mysql.server restart
```

#### **On Windows:**
```cmd
# Stop MySQL service
net stop mysql

# Start MySQL in safe mode
mysqld --skip-grant-tables

# In another command prompt
mysql -u root

# Set password
USE mysql;
UPDATE user SET authentication_string = PASSWORD('Ab*2525125') WHERE User = 'root';
FLUSH PRIVILEGES;
EXIT;

# Restart MySQL service
net start mysql
```

#### **On Ubuntu/Linux:**
```bash
# Stop MySQL
sudo systemctl stop mysql

# Start MySQL in safe mode
sudo mysqld_safe --skip-grant-tables &

# Connect and set password
mysql -u root

USE mysql;
UPDATE user SET authentication_string = PASSWORD('Ab*2525125') WHERE User = 'root';
FLUSH PRIVILEGES;
EXIT;

# Restart MySQL
sudo systemctl restart mysql
```

### **Verification Steps:**

1. **Test connection:**
   ```bash
   mysql -u root -p
   # Enter password: Ab*2525125
   ```

2. **Create the TeknoPhix database:**
   ```sql
   CREATE DATABASE tfc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   SHOW DATABASES;
   EXIT;
   ```

3. **Test from your application:**
   - Visit: http://tfc.local/test/database
   - Should show "Database Connection Successful!"

### **Common Issues:**

#### **Issue: "Access denied for user 'root'@'localhost'"**
**Solution:** The password wasn't set correctly. Repeat the password setup process.

#### **Issue: "Can't connect to MySQL server"**
**Solution:** MySQL service isn't running. Start it:
```bash
# Mac
brew services start mysql

# Linux
sudo systemctl start mysql

# Windows
net start mysql
```

#### **Issue: "Unknown database 'tfc'"**
**Solution:** Create the database:
```sql
mysql -u root -p
CREATE DATABASE tfc;
```

### **Security Note:**
The password `Ab*2525125` is only for localhost development. Never use this password in production environments.

### **Next Steps:**
After setting up the password:
1. Run the database setup script: `mysql -u root -p < database_setup_localhost.sql`
2. Test your application: http://tfc.local/test/database
3. If successful, access your app: http://tfc.local/
