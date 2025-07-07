1) Job Module Update
a) Adding New Job Status:

Parts Pending

Referred to Service Center

Returned (Device not repaired and returned to customer)

b) Dispatch System Improvement:

Add an option: "Dispatch to Referred or Service Center"

Maintain a fixed list of service centers

If dispatched to "Other Service Center", status remains Pending

Once returned from the service center, update status to Ready to Dispatch to Customer

c) For Walk-in Customers:

When selecting Walk-in Customer, a new input box should appear to enter the name

On display, it will show: Ramesh Shrestha (Walk-in Customer)

If name is not entered, display should show: Walk-in Customer only

d) Nepali Date Support:

Enable Nepali date selection and display across the job form and all relevant sections

2) Inventory (Stock) Module Improvement
a) Bulk Import/Export:

Add support for importing/exporting items via CSV or Excel

Fields to be included:

Purchase Price

Selling Price

Minimum Order Level
(Note: Prices may be optional as per requirement)

b) Restrict Technician Privileges:

Technician will not be allowed to:

Add stock

Delete stock

3) Parts Order System
a) Parts Request Feature:

Technicians can request parts

Admin, Super Admin, and Manager can:

View requests

Approve / Reject requests

Process the order

Next Phase (Phase 2):
Revenue Distribution System

Business Profile Setup

# TFC Database Documentation

## Database Dump File
- **File**: `tfc_database_dump.sql`
- **Created**: 2025-07-07 (Updated with Enhanced Features)
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

### 5. `inventory_items` (Enhanced)
- **Purpose**: Inventory management with pricing and categorization
- **Key Fields**: device_name, brand, model, total_stock, purchase_price, selling_price, minimum_order_level, category, description, supplier, status
- **New Features**: Purchase/selling prices, minimum order levels, categories, supplier tracking

### 6. `inventory_movements`
- **Purpose**: Track inventory changes
- **Key Fields**: item_id, movement_type, quantity

### 7. `photos`
- **Purpose**: Photo management for jobs/services
- **Key Fields**: filename, job_id, description

### 8. `referred`
- **Purpose**: Referral system
- **Key Fields**: referrer_id, referred_id, status

### 9. `service_centers` (New)
- **Purpose**: Manage external service centers for job dispatch
- **Key Fields**: name, address, contact_person, phone, email, status
- **Features**: Track jobs sent to external service centers

### 10. `parts_requests` (New)
- **Purpose**: Parts request system for technicians
- **Key Fields**: technician_id, job_id, item_name, quantity_requested, urgency, status, requested_by, approved_by
- **Features**: Request approval workflow, cost tracking, delivery management

### 11. `inventory_import_logs` (New)
- **Purpose**: Track bulk inventory imports
- **Key Fields**: filename, imported_by, total_rows, successful_rows, failed_rows, error_log, status
- **Features**: Import history and error tracking

### 12. `migrations`
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

## Enhanced Features (Phase 1)

### Job Module Enhancements
- **New Job Statuses**: Parts Pending, Referred to Service Center, Ready to Dispatch to Customer, Returned
- **Walk-in Customer Support**: Special handling for customers without accounts
- **Service Center Dispatch**: Track jobs sent to external service centers
- **Nepali Date Support**: Fields for Nepali date entry and display
- **Enhanced Dispatch System**: Multiple dispatch types with tracking

### Inventory Module Improvements
- **Enhanced Fields**: Purchase price, selling price, minimum order levels, categories, suppliers
- **Bulk Import/Export**: CSV/Excel support for inventory management
- **Access Control**: Technicians restricted from adding/deleting stock
- **Import Logging**: Track all bulk import operations with error logs

### Parts Request System
- **Technician Requests**: Technicians can request parts for jobs
- **Approval Workflow**: Admin/Manager approval required
- **Urgency Levels**: Low, Medium, High, Critical priority levels
- **Cost Tracking**: Estimated and actual costs
- **Delivery Management**: Expected and actual delivery dates
- **Status Tracking**: Pending → Approved → Ordered → Received

### Access Control Enhancements
- **Role-based Permissions**: Different access levels for different user roles
- **Technician Restrictions**: Limited inventory management capabilities
- **Admin-only Features**: Service center management, parts request approval

## Notes
- All passwords are hashed using PHP's `password_hash()` function
- Database uses UTF-8 encoding with Nepali language support
- Created for Tech Fix Center (TFC) application
- Contains sample data for testing and development
- Enhanced with Phase 1 improvements for better workflow management
