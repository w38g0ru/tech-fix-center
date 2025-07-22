# TeknoPhix Database Backups

This directory contains database backup files for the TeknoPhix application.

## Backup Files

### Full Database Backup
- **File**: `tfc_database_backup_YYYYMMDD_HHMMSS.sql`
- **Description**: Complete database dump including structure, data, routines, and triggers
- **Usage**: Full restoration of the database
- **Compressed**: `.sql.gz` version available for storage efficiency

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

## Backup Creation Commands

### Full Backup
```bash
mysqldump -u root --databases tfc --routines --triggers --single-transaction --lock-tables=false --add-drop-database --complete-insert --extended-insert --comments > tfc_database_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Structure Only
```bash
mysqldump -u root --no-data --databases tfc --routines --triggers > tfc_structure_only_$(date +%Y%m%d_%H%M%S).sql
```

## Notes

- Backups are created automatically during major updates
- Keep multiple backup versions for rollback capability
- Test restoration in development environment before production use
- Compressed files save ~80% storage space
- All backups include UTF-8 character set support

## Security

- Backup files contain sensitive data
- Store securely and limit access
- Consider encryption for production backups
- Regular backup rotation recommended

---
*Generated automatically by TeknoPhix backup system*
