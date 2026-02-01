-- Test Data Insertion Script
-- Based on Phase 2: Database Design - Step 2.2
-- Run after schema.sql

USE crud_asbl_ong;

-- Insert Test Users
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$examplehashedpassword', 'admin@asbl-ong.org', 'admin'),
('moderator1', '$2y$10$examplehashedpassword', 'mod@asbl-ong.org', 'moderator'),
('visitor1', '$2y$10$examplehashedpassword', 'visitor@asbl-ong.org', 'visitor');

-- Insert Test Members
INSERT INTO members (first_name, last_name, email, phone, address, join_date, status) VALUES
('Jean', 'Dupont', 'jean.dupont@email.com', '+32 123 456 789', 'Rue de la Paix 1, Brussels', '2023-01-15', 'active'),
('Marie', 'Martin', 'marie.martin@email.com', '+32 987 654 321', 'Avenue des Arts 5, Brussels', '2023-02-20', 'active'),
('Pierre', 'Dubois', 'pierre.dubois@email.com', '+32 555 123 456', 'Place Royale 10, Brussels', '2023-03-10', 'inactive'),
('Sophie', 'Leroy', 'sophie.leroy@email.com', '+32 444 789 012', 'Boulevard Anspach 15, Brussels', '2023-04-05', 'active');

-- Insert Test Projects
INSERT INTO projects (name, description, start_date, end_date, budget, status, manager_id) VALUES
('Projet Environnement', 'Campagne de sensibilisation à l\'environnement', '2023-06-01', '2023-12-31', 5000.00, 'active', 1),
('Aide Alimentaire', 'Distribution de nourriture aux familles nécessiteuses', '2023-07-01', '2024-06-30', 10000.00, 'planning', 2),
('Éducation pour Tous', 'Programme d\'alphabétisation pour adultes', '2023-09-01', '2024-08-31', 7500.00, 'active', 1);

-- Insert Test Events
INSERT INTO events (title, description, event_date, location, organizer_id, max_participants, status) VALUES
('Conférence Climat', 'Discussion sur les changements climatiques', '2023-10-15 14:00:00', 'Salle Communale, Brussels', 1, 50, 'planned'),
('Collecte de Fonds', 'Événement de collecte pour l\'aide alimentaire', '2023-11-20 18:00:00', 'Centre Culturel, Brussels', 2, 100, 'planned'),
('Atelier Éducation', 'Session d\'alphabétisation', '2023-12-05 10:00:00', 'Bibliothèque Centrale, Brussels', 1, 30, 'completed');

-- Insert Test Donations
INSERT INTO donations (donor_name, donor_email, amount, donation_date, project_id, payment_method, notes) VALUES
('Anonymous', NULL, 100.00, '2023-09-01', 1, 'cash', 'Don anonyme'),
('Jean Dupont', 'jean.dupont@email.com', 250.00, '2023-09-15', 2, 'bank_transfer', 'Pour l\'aide alimentaire'),
('Marie Martin', 'marie.martin@email.com', 50.00, '2023-10-01', NULL, 'online', 'Don général'),
('Pierre Dubois', 'pierre.dubois@email.com', 500.00, '2023-10-10', 3, 'bank_transfer', 'Soutien à l\'éducation'),
('Sophie Leroy', 'sophie.leroy@email.com', 75.00, '2023-11-01', 1, 'cash', 'Pour l\'environnement');