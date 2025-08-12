-- Update admin@techfixcenter.com user role to technician
-- This script changes only the role, no other user data is modified

UPDATE admin_users 
SET role = 'technician', 
    updated_at = NOW() 
WHERE email = 'admin@techfixcenter.com';

-- Verify the update
SELECT id, email, role, updated_at 
FROM admin_users 
WHERE email = 'admin@techfixcenter.com';
