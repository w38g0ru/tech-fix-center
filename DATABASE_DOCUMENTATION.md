# Tech Fix Center Database Documentation

## 📊 **Database Overview**

The Tech Fix Center database is designed to manage a comprehensive repair service system with inventory management, job tracking, and user management capabilities.

### **Database Files**
- **`database_dump.sql`** - Complete database with structure and sample data
- **`database_structure_only.sql`** - Database structure only (for development)
- **`add_walk_in_mobile.sql`** - Migration for walk-in customer mobile field

## 🗄️ **Database Schema**

### **Core Tables**

#### **1. users**
Manages all system users including customers, technicians, admins.
```sql
- id (Primary Key)
- name, email, mobile_number
- password (hashed)
- role (superadmin, admin, manager, technician, customer)
- user_type, status
- timestamps
```

#### **2. technicians**
Dedicated technician information with specializations.
```sql
- id (Primary Key)
- name, email, mobile_number
- specialization, experience_years
- status (active/inactive)
- timestamps
```

#### **3. jobs**
Core job/repair tracking with walk-in customer support.
```sql
- id (Primary Key)
- user_id (FK to users) - for registered customers
- walk_in_customer_name, walk_in_customer_mobile - for walk-in customers
- device_name, serial_number, problem
- technician_id (FK to technicians)
- status (pending, in_progress, completed, cancelled, dispatched, returned)
- charge, dispatch_type, service_center_id
- dispatch_date, nepali_date, expected_return_date, actual_return_date
- dispatch_notes, timestamps
```

#### **4. inventory_items**
Inventory management with pricing support.
```sql
- id (Primary Key)
- device_name, brand, model, category
- total_stock, purchase_price, selling_price, minimum_order_level
- supplier, description
- status (Active, Inactive, Discontinued)
- timestamps
```

#### **5. service_centers**
External service center management.
```sql
- id (Primary Key)
- name, address, contact_number, email
- status (active/inactive)
- timestamps
```

### **Supporting Tables**

#### **6. inventory_movements**
Track inventory stock movements (in/out).
```sql
- id (Primary Key)
- inventory_item_id (FK to inventory_items)
- movement_type (in/out)
- quantity, notes
- created_by (FK to users)
- created_at
```

#### **7. parts_requests**
Technician parts request system.
```sql
- id (Primary Key)
- technician_id (FK to technicians)
- job_id (FK to jobs) - optional
- part_name, quantity, description
- urgency (low, medium, high, critical)
- status (pending, approved, rejected, fulfilled)
- requested_date, approved_by, approved_date
- notes, timestamps
```

#### **8. Photo Tables**
Photo management for jobs, inventory, and dispatch.
```sql
job_photos: job_id, photo_path, photo_description, uploaded_by
inventory_photos: inventory_item_id, photo_path, photo_description, uploaded_by
dispatch_photos: job_id, photo_path, photo_description, uploaded_by
```

## 🔗 **Relationships**

### **Foreign Key Constraints**
- `jobs.user_id` → `users.id` (ON DELETE SET NULL)
- `jobs.technician_id` → `technicians.id` (ON DELETE SET NULL)
- `jobs.service_center_id` → `service_centers.id` (ON DELETE SET NULL)
- `inventory_movements.inventory_item_id` → `inventory_items.id` (ON DELETE CASCADE)
- `parts_requests.technician_id` → `technicians.id` (ON DELETE CASCADE)
- `parts_requests.job_id` → `jobs.id` (ON DELETE SET NULL)
- All photo tables → respective parent tables (ON DELETE CASCADE)

### **Key Features**
- **Walk-in Customer Support**: Jobs can be linked to registered users OR walk-in customers
- **Pricing Management**: Purchase price, selling price, minimum order levels
- **Photo Support**: Multiple photos for jobs, inventory items, and dispatch
- **Parts Request System**: Technicians can request parts with approval workflow
- **Inventory Tracking**: Stock movements with user attribution

## 📝 **Sample Data**

### **Users**
- Super Admin (admin@techfixcenter.com)
- Sample customers with Nepali names (रमेश श्रेष्ठ, सुनिता गुरुङ)

### **Technicians**
- अनिल तामाङ (Mobile Phone Repair)
- प्रिया शर्मा (Laptop Repair)  
- राजेश थापा (Computer Hardware)

### **Service Centers**
- काठमाडौं सर्भिस सेन्टर
- पोखरा सर्भिस सेन्टर
- चितवन सर्भिस सेन्टर

### **Inventory Items**
- iPhone Screen (Purchase: NPR 15,000, Selling: NPR 18,000)
- Samsung Battery (Purchase: NPR 2,500, Selling: NPR 3,000)
- MacBook Keyboard (Purchase: NPR 8,000, Selling: NPR 10,000)
- Dell RAM (Purchase: NPR 3,500, Selling: NPR 4,200)
- Charging Cable (Purchase: NPR 200, Selling: NPR 350)

### **Jobs**
- Mix of registered customers and walk-in customers
- Various statuses (pending, in_progress, dispatched)
- Nepali customer names (बिनोद पौडेल, सरिता राई)

## 🚀 **Usage Instructions**

### **Fresh Installation**
1. Create database: `CREATE DATABASE tech_fix_center;`
2. Import structure: `mysql tech_fix_center < database_structure_only.sql`
3. Add sample data if needed: `mysql tech_fix_center < database_dump.sql`

### **Development Setup**
1. Use `database_dump.sql` for complete setup with sample data
2. Default admin login: admin@techfixcenter.com / password

### **Production Setup**
1. Use `database_structure_only.sql` for clean structure
2. Create your own admin user
3. Configure proper database credentials in CodeIgniter

## 🔧 **Database Configuration**

### **CodeIgniter Database Config**
```php
// app/Config/Database.php
public array $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'tech_fix_center',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => true,
    'charset'  => 'utf8mb4',
    'DBCollat' => 'utf8mb4_unicode_ci',
];
```

### **Required MySQL Version**
- MySQL 5.7+ or MariaDB 10.2+
- UTF8MB4 support for Nepali characters
- InnoDB engine for foreign key support

## 📊 **Key Features Supported**

### **Walk-in Customer Management**
- Jobs can be created for walk-in customers without user registration
- Optional name and mobile number fields
- Proper display formatting in all views

### **Inventory Management with Pricing**
- Purchase price and selling price tracking
- Minimum order level for reorder alerts
- Stock movement tracking
- Bulk import/export via CSV

### **Photo Management**
- Multiple photos per job, inventory item, and dispatch
- Photo descriptions and user attribution
- Organized storage and retrieval

### **Parts Request System**
- Technicians can request parts
- Approval workflow for admins/managers
- Link to specific jobs (optional)
- Urgency levels and status tracking

### **Multi-role User System**
- Superadmin, Admin, Manager, Technician, Customer roles
- Proper permission handling
- User type categorization

The database is designed to be scalable, maintainable, and supports all the core features of the Tech Fix Center application! 🎉
