<?php
/**
 * Conceptual Data Model (ER Diagram Representation)
 *
 * Based on Phase 2: Database Design - Step 2.1 Conceptual Modeling
 *
 * Entities and Attributes:
 *
 * User (System Users for Authentication and Roles)
 * - id: INT (Primary Key)
 * - username: VARCHAR(50) UNIQUE NOT NULL
 * - password: VARCHAR(255) NOT NULL (Hashed)
 * - email: VARCHAR(100) UNIQUE NOT NULL
 * - role: ENUM('admin', 'moderator', 'visitor') DEFAULT 'visitor'
 * - created_at: TIMESTAMP
 * - updated_at: TIMESTAMP
 *
 * Member (Association Members)
 * - id: INT (Primary Key)
 * - first_name: VARCHAR(50) NOT NULL
 * - last_name: VARCHAR(50) NOT NULL
 * - email: VARCHAR(100) UNIQUE NOT NULL
 * - phone: VARCHAR(20)
 * - address: TEXT
 * - join_date: DATE NOT NULL
 * - status: ENUM('active', 'inactive') DEFAULT 'active'
 * - created_at: TIMESTAMP
 * - updated_at: TIMESTAMP
 *
 * Event (Events Organized by the Association)
 * - id: INT (Primary Key)
 * - title: VARCHAR(100) NOT NULL
 * - description: TEXT
 * - event_date: DATETIME NOT NULL
 * - location: VARCHAR(100)
 * - organizer_id: INT (Foreign Key to User)
 * - max_participants: INT
 * - status: ENUM('planned', 'ongoing', 'completed', 'cancelled') DEFAULT 'planned'
 * - created_at: TIMESTAMP
 * - updated_at: TIMESTAMP
 *
 * Donation (Donations Received)
 * - id: INT (Primary Key)
 * - donor_name: VARCHAR(100) NOT NULL
 * - donor_email: VARCHAR(100)
 * - amount: DECIMAL(10,2) NOT NULL
 * - donation_date: DATE NOT NULL
 * - project_id: INT (Foreign Key to Project, nullable)
 * - payment_method: ENUM('cash', 'bank_transfer', 'online') DEFAULT 'cash'
 * - notes: TEXT
 * - created_at: TIMESTAMP
 *
 * Project (Projects Managed by the Association)
 * - id: INT (Primary Key)
 * - name: VARCHAR(100) NOT NULL
 * - description: TEXT
 * - start_date: DATE
 * - end_date: DATE
 * - budget: DECIMAL(10,2)
 * - status: ENUM('planning', 'active', 'completed', 'on_hold') DEFAULT 'planning'
 * - manager_id: INT (Foreign Key to User)
 * - created_at: TIMESTAMP
 * - updated_at: TIMESTAMP
 *
 * Relationships:
 * - User 1:N Event (organizer_id) - One user can organize many events
 * - User 1:N Project (manager_id) - One user can manage many projects
 * - Project 1:N Donation (project_id) - One project can receive many donations (optional)
 *
 * Integrity Constraints:
 * - Primary Keys: id for all entities
 * - Foreign Keys: organizer_id -> User.id, manager_id -> User.id, project_id -> Project.id
 * - Unique: username, email (User), email (Member)
 * - Not Null: As specified
 * - Check: ENUM values
 * - Default: As specified
 *
 * No many-to-many relationships identified in initial model.
 * Potential future extensions: Event-Participant (many-to-many with Member)
 */
?>