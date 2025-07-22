# TeknoPhix Database Backups

This directory contains database backup files for the TeknoPhix application.

## Backup Files

### Full Database Backup (MySQL 8.0+)
- **File**: `tfc_database_backup_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump including structure, data, routines, and triggers
- **MySQL Version**: 8.0+ (uses utf8mb4_0900_ai_ci collation)
- **Usage**: Full restoration on MySQL 8.0+ servers
- **Compressed**: `.sql.gz` version available for storage efficiency

### Compatible Database Backup (MySQL 5.7+)
- **File**: `tfc_compatible_backup_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump with utf8mb4_unicode_ci collation
- **MySQL Version**: 5.7+ compatible
- **Usage**: Full restoration on MySQL 5.7+ servers

### MySQL 5.7 Compatible Backup
- **File**: `tfc_mysql57_compatible_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump with utf8mb4_general_ci collation, no encryption
- **MySQL Version**: 5.7 and older
- **Usage**: Full restoration on older MySQL servers

### Universal Compatible Backup
- **File**: `tfc_universal_compatible_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump with consistent utf8mb4_unicode_ci collation
- **MySQL Version**: 5.7+ (recommended for most environments)
- **Usage**: Universal restoration across different MySQL versions

### phpMyAdmin Import Version
- **File**: `tfc_phpmyadmin_import_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump optimized for phpMyAdmin import
- **Features**: No CREATE DATABASE statement, compatible collations, DROP TABLE statements
- **MySQL Version**: 5.7+ compatible
- **Usage**: Direct import via phpMyAdmin interface (recommended for shared hosting)

### No Create DB Version
- **File**: `tfc_no_create_db_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump without CREATE DATABASE statement
- **Usage**: Import into existing database when user lacks database creation privileges

### Structure Only Backup
- **File**: `tfc_structure_only_YYYYMMDD_HHMMSS.sql`
- **Description**: Database structure only (tables, indexes, constraints) without data
- **Usage**: Setting up new environments or comparing schema changes

## Database Information

- **Database Name**: `tfc`
- **Application**: TeknoPhix - Tech Fix Center Management System
- **Version**: Latest as of backup date
- **Tables**: All application tables including:
  - admin_users (user management)
  - jobs (repair jobs)
  - inventory (parts and components)
  - parts_requests (parts ordering)
  - service_centers (external service providers)
  - movements (inventory tracking)
  - photos (job documentation)
  - referred (external dispatches)
  - user_activity_logs (audit trail)

## Restoration Instructions

### Full Database Restore
```bash
# Restore complete database
mysql -u root -p < tfc_database_backup_YYYYMMDD_HHMMSS.sql

# Or from compressed file
gunzip -c tfc_database_backup_YYYYMMDD_HHMMSS.sql.gz | mysql -u root -p
```

### Structure Only Restore
```bash
# Restore structure only
mysql -u root -p < tfc_structure_only_YYYYMMDD_HHMMSS.sql
```

### phpMyAdmin Import
1. **Login to phpMyAdmin**
2. **Select your database** (e.g., 'tfc')
3. **Go to Import tab**
4. **Choose file**: `tfc_phpmyadmin_import_YYYYMMDD_HHMMSS.sql`
5. **Set Character set**: `utf8mb4`
6. **Click Go**

### Command Line Import (No Database Creation)
```bash
# Import into existing database
mysql -u your_username -p tfc < tfc_phpmyadmin_import_YYYYMMDD_HHMMSS.sql
```

## Backup Creation Commands

### Full Backup
```bash
mysqldump -u root --databases tfc --routines --triggers --single-transaction --lock-tables=false --add-drop-database --complete-insert --extended-insert --comments > tfc_database_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Structure Only
```bash
mysqldump -u root --no-data --databases tfc --routines --triggers > tfc_structure_only_$(date +%Y%m%d_%H%M%S).sql
```

## Troubleshooting

### Collation Errors
If you encounter errors like:
```
#1273 - Unknown collation: 'utf8mb4_0900_ai_ci'
```

**Solution**: Use the compatible backup files:
- For MySQL 5.7+: Use `tfc_universal_compatible_*.sql`
- For older MySQL: Use `tfc_mysql57_compatible_*.sql`

### Character Set Issues
If you see character encoding problems:
```bash
# Set proper character set before import
mysql -u root -p --default-character-set=utf8mb4 < backup_file.sql
```

### Large File Import
For large backup files:
```bash
# Increase MySQL timeout settings
mysql -u root -p -e "SET GLOBAL max_allowed_packet=1073741824;"
mysql -u root -p -e "SET GLOBAL wait_timeout=28800;"
```

## Notes

- Backups are created automatically during major updates
- Keep multiple backup versions for rollback capability
- Test restoration in development environment before production use
- Compressed files save ~80% storage space
- All backups include UTF-8 character set support
- Use compatible versions to avoid collation issues

## Security

- Backup files contain sensitive data
- Store securely and limit access
- Consider encryption for production backups
- Regular backup rotation recommended

---
*Generated automatically by TeknoPhix backup system*
