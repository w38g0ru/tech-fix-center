# TFC Database Documentation

## Database Dump File
- **File**: `tfc_database_dump.sql`
- **Created**: 2025-07-06
- **Database**: `tfc`
- **MySQL Version**: 8.0.42

## Tables Included

### 1. `admin_users`
- **Purpose**: System administrators and staff users
- **Key Fields**: username, email, password, role, status
- **Roles**: superadmin, admin, technician, user
- **Sample Users**:
  - superadmin/superadmin@tfc.com (सुपर एडमिन)
  - admin/admin@tfc.com (एडमिन यूजर)
  - technician/technician@tfc.com (टेक्निशियन यूजर)

### 2. `users`
- **Purpose**: Customer/client users
- **Key Fields**: name, email, phone, address

### 3. `technicians`
- **Purpose**: Technician profiles and information
- **Key Fields**: name, email, phone, specialization

### 4. `jobs`
- **Purpose**: Service jobs/tickets
- **Key Fields**: title, description, status, assigned_technician

### 5. `inventory_items`
- **Purpose**: Inventory management
- **Key Fields**: name, category, quantity, price

### 6. `inventory_movements`
- **Purpose**: Track inventory changes
- **Key Fields**: item_id, movement_type, quantity

### 7. `photos`
- **Purpose**: Photo management for jobs/services
- **Key Fields**: filename, job_id, description

### 8. `referred`
- **Purpose**: Referral system
- **Key Fields**: referrer_id, referred_id, status

### 9. `migrations`
- **Purpose**: CodeIgniter migration tracking
- **Key Fields**: version, class, group, namespace

## How to Import

### Local Development
```bash
mysql -u root tfc < app/Models/tfc_database_dump.sql
```

### Production
```bash
mysql -u [username] -p [database_name] < app/Models/tfc_database_dump.sql
```

## Default Login Credentials

### Super Admin
- **Username**: superadmin
- **Password**: password123
- **Email**: superadmin@tfc.com

### Admin
- **Username**: admin  
- **Password**: password123
- **Email**: admin@tfc.com

### Technician
- **Username**: technician
- **Password**: password123
- **Email**: technician@tfc.com

### Regular User
- **Username**: user
- **Password**: password123
- **Email**: user@tfc.com

## Notes
- All passwords are hashed using PHP's `password_hash()` function
- Database uses UTF-8 encoding with Nepali language support
- Created for Tech Fix Center (TFC) application
- Contains sample data for testing and development
