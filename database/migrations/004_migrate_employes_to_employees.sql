-- Migrate employee data from old 'employes' table to new 'employees' table

-- First, let's check what data we need to migrate
USE crud_asbl_ong;

-- Show existing data
SELECT 'Old employes table count:', COUNT(*) FROM employes;
SELECT 'New employees table count:', COUNT(*) FROM employees;

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS=0;

-- Clear the new employees table (optional - only if you want fresh data)
-- DELETE FROM employees;

-- Insert data from old to new table
INSERT INTO employees (
    user_id,
    first_name,
    last_name,
    email,
    phone,
    birth_date,
    gender,
    nationality,
    address,
    city,
    postal_code,
    country,
    employee_number,
    position,
    department,
    hire_date,
    employment_status,
    employment_type,
    manager_id,
    salary_gross,
    currency,
    social_security_number,
    tax_id,
    documents_path,
    notes,
    created_at,
    updated_at
)
SELECT 
    user_id,
    first_name,
    last_name,
    email,
    phone,
    NULL as birth_date,
    'Other' as gender,
    NULL as nationality,
    address,
    NULL as city,
    NULL as postal_code,
    NULL as country,
    NULL as employee_number,
    NULL as position,
    NULL as department,
    hire_date,
    CASE 
        WHEN status = 'active' THEN 'active'
        WHEN status = 'inactive' THEN 'on_leave'
        WHEN status = 'archived' THEN 'terminated'
        ELSE 'active'
    END as employment_status,
    'CDI' as employment_type,
    NULL as manager_id,
    NULL as salary_gross,
    'EUR' as currency,
    NULL as social_security_number,
    NULL as tax_id,
    NULL as documents_path,
    NULL as notes,
    created_at,
    updated_at
FROM employes
ON DUPLICATE KEY UPDATE
    user_id = VALUES(user_id),
    first_name = VALUES(first_name),
    last_name = VALUES(last_name),
    email = VALUES(email),
    phone = VALUES(phone),
    address = VALUES(address),
    hire_date = VALUES(hire_date),
    employment_status = VALUES(employment_status),
    updated_at = NOW();

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS=1;

-- Verify migration
SELECT 'After migration - Old employes count:', COUNT(*) FROM employes;
SELECT 'After migration - New employees count:', COUNT(*) FROM employees;
