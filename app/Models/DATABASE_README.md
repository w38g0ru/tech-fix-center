# Tech Fix Center Database Files

## 📁 **Database Files in Model Folder**

### **Complete Database Dump**
- **`tech_fix_center_complete_dump.sql`** - Complete database with structure and comprehensive sample data

### **Migration Files**
- **`database_dump.sql`** - Original database dump
- **`database_structure_only.sql`** - Structure only (no data)
- **`add_walk_in_mobile.sql`** - Walk-in customer mobile field migration

## 🚀 **Quick Setup Instructions**

### **Fresh Installation**
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE tech_fix_center;"

# Import complete database
mysql -u root -p tech_fix_center < app/Models/tech_fix_center_complete_dump.sql
```

### **Development Setup**
```bash
# For development with sample data
mysql -u root -p tech_fix_center < app/Models/tech_fix_center_complete_dump.sql
```

### **Production Setup**
```bash
# For production (structure only)
mysql -u root -p tech_fix_center < app/Models/database_structure_only.sql
```

## 📊 **Database Contents**

### **Sample Users**
- **Super Admin**: admin@techfixcenter.com (password: password)
- **Admin**: admin2@techfixcenter.com (password: password)
- **Manager**: manager@techfixcenter.com (password: password)
- **Customers**: रमेश श्रेष्ठ, सुनिता गुरुङ, बिमल पौडेल, कमला शर्मा

### **Sample Technicians**
- अनिल तामाङ (Mobile Phone Repair)
- प्रिया शर्मा (Laptop Repair)
- राजेश थापा (Computer Hardware)
- सुमन राई (Tablet Repair)
- गीता लामा (Gaming Console Repair)

### **Sample Service Centers**
- काठमाडौं सर्भिस सेन्टर
- पोखरा सर्भिस सेन्टर
- चितवन सर्भिस सेन्टर
- बुटवल सर्भिस सेन्टर
- धरान सर्भिस सेन्टर

### **Sample Inventory (with Pricing)**
- iPhone Screen: NPR 15,000 → NPR 18,000
- Samsung Battery: NPR 2,500 → NPR 3,000
- MacBook Keyboard: NPR 8,000 → NPR 10,000
- Dell RAM: NPR 3,500 → NPR 4,200
- iPad Screen: NPR 12,000 → NPR 15,000
- PlayStation Controller: NPR 6,000 → NPR 8,000

### **Sample Jobs**
- Mix of registered customers and walk-in customers
- Various statuses (pending, in_progress, completed, dispatched)
- Walk-in customers: बिनोद पौडेल, सरिता राई, मनोज खड्का, राम बहादुर

### **Sample Parts Requests**
- Technician requests with different urgency levels
- Various statuses (pending, approved, fulfilled)
- Linked to specific jobs

## 🔧 **Database Features**

### **Tables Included**
- `users` - Multi-role user management
- `technicians` - Technician profiles
- `service_centers` - External service centers
- `jobs` - Job tracking with walk-in customer support
- `inventory_items` - Inventory with pricing fields
- `inventory_movements` - Stock movement tracking
- `parts_requests` - Parts request system
- `job_photos`, `inventory_photos`, `dispatch_photos` - Photo management
- `settings` - Application configuration

### **Views Created**
- `jobs_with_customers` - Jobs with customer information
- `low_stock_items` - Items below minimum order level
- `inventory_with_movements` - Inventory with movement summary

### **Indexes Added**
- Performance indexes for common queries
- Foreign key indexes
- Date-based indexes for reporting

## 💰 **Pricing Fields**
All inventory items include:
- `purchase_price` - Cost price (optional)
- `selling_price` - Retail price (optional)
- `minimum_order_level` - Reorder threshold (optional)

## 👥 **Walk-in Customer Support**
Jobs table supports:
- `user_id` - For registered customers
- `walk_in_customer_name` - Walk-in customer name (optional)
- `walk_in_customer_mobile` - Walk-in customer mobile (optional)

## 🔐 **Default Login Credentials**
- **Email**: admin@techfixcenter.com
- **Password**: password
- **Role**: Super Admin

## 📝 **Notes**
- All passwords are hashed using bcrypt
- UTF8MB4 encoding for Nepali character support
- Foreign key constraints properly configured
- Sample data includes realistic Nepali context
- Ready for immediate development and testing

## 🛠️ **CodeIgniter Configuration**
Update your `app/Config/Database.php`:
```php
public array $default = [
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'tech_fix_center',
    'DBDriver' => 'MySQLi',
    'charset'  => 'utf8mb4',
    'DBCollat' => 'utf8mb4_unicode_ci',
];
```

The database is ready for immediate use with comprehensive sample data! 🎉
