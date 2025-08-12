-- Fix jobs table foreign key constraint
-- This script fixes the incorrect foreign key constraint that references admin_users instead of users

-- Step 1: Check current foreign key constraints
SELECT 
    CONSTRAINT_NAME, 
    REFERENCED_TABLE_NAME,
    COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'user_id' 
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Step 2: Clean up any invalid user_id references
-- Find jobs with user_id that don't exist in users table
SELECT 
    j.id, 
    j.user_id,
    j.walk_in_customer_name,
    j.device_name
FROM jobs j 
LEFT JOIN users u ON j.user_id = u.id 
WHERE j.user_id IS NOT NULL AND u.id IS NULL;

-- Set invalid user_id to NULL (uncomment if needed)
-- UPDATE jobs 
-- SET user_id = NULL 
-- WHERE user_id IS NOT NULL 
-- AND user_id NOT IN (SELECT id FROM users);

-- Step 3: Drop incorrect foreign key constraint (if it exists)
-- Replace 'jobs_user_id_foreign' with the actual constraint name from Step 1
-- ALTER TABLE jobs DROP FOREIGN KEY jobs_user_id_foreign;

-- Step 4: Add correct foreign key constraint
-- ALTER TABLE jobs 
-- ADD CONSTRAINT jobs_user_id_foreign 
-- FOREIGN KEY (user_id) REFERENCES users(id) 
-- ON DELETE SET NULL ON UPDATE CASCADE;

-- Step 5: Verify the fix
SELECT 
    CONSTRAINT_NAME, 
    REFERENCED_TABLE_NAME,
    COLUMN_NAME,
    DELETE_RULE,
    UPDATE_RULE
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jobs' 
AND COLUMN_NAME = 'user_id' 
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Test job creation (uncomment to test)
-- INSERT INTO jobs (user_id, device_name, problem, status, created_at) 
-- VALUES (NULL, 'Test Device', 'Test problem', 'Pending', NOW());
