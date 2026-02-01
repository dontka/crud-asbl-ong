<?php
/**
 * Entities Definition for CRUD System
 * 
 * This file defines the key entities and their attributes for the ABNL/ONG management system.
 * Based on Phase 1: Preparation and Planning - Step 1.1 Analysis of Needs and Requirements Collection
 * 
 * Entities identified:
 * - User: For authentication and roles
 * - Member: For association members
 * - Event: For events organized by the association
 * - Donation: For donations received
 * - Project: For projects managed by the association
 * 
 * User roles: admin, moderator, visitor
 * 
 * CRUD functionalities: Basic CRUD for all entities, plus advanced features like search, filters, reports.
 */

// Define entities with their attributes (SQL-like for reference)
$entities = [
    'User' => [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'username' => 'VARCHAR(50) UNIQUE NOT NULL',
        'password' => 'VARCHAR(255) NOT NULL', // Hashed
        'email' => 'VARCHAR(100) UNIQUE NOT NULL',
        'role' => "ENUM('admin', 'moderator', 'visitor') DEFAULT 'visitor'",
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ],
    'Member' => [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'first_name' => 'VARCHAR(50) NOT NULL',
        'last_name' => 'VARCHAR(50) NOT NULL',
        'email' => 'VARCHAR(100) UNIQUE NOT NULL',
        'phone' => 'VARCHAR(20)',
        'address' => 'TEXT',
        'join_date' => 'DATE NOT NULL',
        'status' => "ENUM('active', 'inactive') DEFAULT 'active'",
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ],
    'Event' => [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'title' => 'VARCHAR(100) NOT NULL',
        'description' => 'TEXT',
        'event_date' => 'DATETIME NOT NULL',
        'location' => 'VARCHAR(100)',
        'organizer_id' => 'INT', // Foreign key to User
        'max_participants' => 'INT',
        'status' => "ENUM('planned', 'ongoing', 'completed', 'cancelled') DEFAULT 'planned'",
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ],
    'Donation' => [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'donor_name' => 'VARCHAR(100) NOT NULL',
        'donor_email' => 'VARCHAR(100)',
        'amount' => 'DECIMAL(10,2) NOT NULL',
        'donation_date' => 'DATE NOT NULL',
        'project_id' => 'INT', // Foreign key to Project, nullable
        'payment_method' => "ENUM('cash', 'bank_transfer', 'online') DEFAULT 'cash'",
        'notes' => 'TEXT',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ],
    'Project' => [
        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
        'name' => 'VARCHAR(100) NOT NULL',
        'description' => 'TEXT',
        'start_date' => 'DATE',
        'end_date' => 'DATE',
        'budget' => 'DECIMAL(10,2)',
        'status' => "ENUM('planning', 'active', 'completed', 'on_hold') DEFAULT 'planning'",
        'manager_id' => 'INT', // Foreign key to User
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ]
];

// Relationships (for reference)
// User 1:N Member (one user can manage many members? Wait, perhaps Member is separate)
// Actually, Member might be the same as User, but let's keep separate as per plan.
// Event: organizer_id -> User.id
// Donation: project_id -> Project.id (optional)
// Project: manager_id -> User.id

// Functional Requirements Summary (in comments):
/*
- User Management: Registration, login, logout, role-based access
- Member Management: CRUD members, search by name/email
- Event Management: CRUD events, participant registration, status tracking
- Donation Management: Record donations, link to projects, generate reports
- Project Management: CRUD projects, assign managers, track progress
- Dashboard: Statistics (member count, total donations, active projects)
- Search and Filters: Across all entities
- Reports: Export to CSV
- Security: Password hashing, CSRF protection, input validation
- Roles: Admin (full access), Moderator (limited CRUD), Visitor (read-only)
*/
?>