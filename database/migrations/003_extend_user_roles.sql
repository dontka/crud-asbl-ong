-- Migration: Add new user roles to support extended RBAC
-- Created: 2026-02-04
-- Purpose: Extend the user roles to match ROLES.md specifications

ALTER TABLE users MODIFY role ENUM(
    'admin',                  -- Full system access
    'moderator',              -- Content moderation
    'hr_manager',             -- HR management
    'accountant',             -- Financial management
    'project_manager',        -- Project management
    'crm_officer',            -- CRM and relationships
    'member',                 -- Standard member
    'volunteer',              -- Volunteer access
    'guest',                  -- Guest/beneficiary access
    'supervisor',             -- Supervisory access
    'auditor',                -- Read-only audit access
    'security_officer',       -- Security management
    'it_officer',             -- IT/Infrastructure management
    'communication_officer',  -- Communication management
    'compliance_officer',     -- Compliance/RGPD management
    'marketplace_officer',    -- Marketplace/plugins management
    'support_officer',        -- Support/helpdesk
    'training_officer',       -- Training management
    'quality_officer'         -- Quality management
) DEFAULT 'visitor';

-- Create an index on the role column for better performance
CREATE INDEX idx_users_role ON users(role);
