-- Database Schema for CRUD System
-- Based on Phase 2: Database Design - Step 2.2 Physical Modeling and SQL Scripts
-- Database Name: crud_asbl_ong

-- Create Database
CREATE DATABASE IF NOT EXISTS crud_asbl_ong CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_asbl_ong;

-- Users Table (System Users)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'moderator', 'visitor') DEFAULT 'visitor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Members Table (Association Members)
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    join_date DATE NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Projects Table (Projects)
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    budget DECIMAL(10,2),
    status ENUM('planning', 'active', 'completed', 'on_hold') DEFAULT 'planning',
    manager_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Events Table (Events)
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(100),
    organizer_id INT,
    max_participants INT,
    status ENUM('planned', 'ongoing', 'completed', 'cancelled') DEFAULT 'planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Donations Table (Donations)
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_name VARCHAR(100) NOT NULL,
    donor_email VARCHAR(100),
    amount DECIMAL(10,2) NOT NULL,
    donation_date DATE NOT NULL,
    project_id INT,
    payment_method ENUM('cash', 'bank_transfer', 'online') DEFAULT 'cash',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL
);

-- Indexes for Performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_members_email ON members(email);
CREATE INDEX idx_events_organizer ON events(organizer_id);
CREATE INDEX idx_events_date ON events(event_date);
CREATE INDEX idx_projects_manager ON projects(manager_id);
CREATE INDEX idx_donations_project ON donations(project_id);
CREATE INDEX idx_donations_date ON donations(donation_date);

-- =============================
-- TABLES AVANCEES (RH, FINANCE, CRM, DOCUMENTS, ETC.)
-- =============================

-- Employés (RH)
CREATE TABLE employes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    hire_date DATE NOT NULL,
    status ENUM('active', 'inactive', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Contrats (RH)
CREATE TABLE contrats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employe_id INT NOT NULL,
    type ENUM('CDI', 'CDD', 'Stage', 'Autre') DEFAULT 'CDI',
    start_date DATE NOT NULL,
    end_date DATE,
    status ENUM('actif', 'termine', 'suspendu') DEFAULT 'actif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employe_id) REFERENCES employes(id) ON DELETE CASCADE
);

-- Absences & Congés (RH)
CREATE TABLE absences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employe_id INT NOT NULL,
    type ENUM('conge', 'maladie', 'autre') DEFAULT 'conge',
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('demande', 'valide', 'refuse') DEFAULT 'demande',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employe_id) REFERENCES employes(id) ON DELETE CASCADE
);

-- Pointages (RH)
CREATE TABLE pointages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employe_id INT NOT NULL,
    date DATE NOT NULL,
    heures DECIMAL(5,2) NOT NULL,
    type ENUM('travail', 'absence', 'autre') DEFAULT 'travail',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employe_id) REFERENCES employes(id) ON DELETE CASCADE
);

-- Budgets (Finance)
CREATE TABLE budgets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT,
    name VARCHAR(100) NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(10) DEFAULT 'EUR',
    period VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL
);

-- Écritures Comptables (Finance)
CREATE TABLE ecritures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    description VARCHAR(255),
    debit DECIMAL(12,2) DEFAULT 0,
    credit DECIMAL(12,2) DEFAULT 0,
    project_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL
);

-- Factures (Finance)
CREATE TABLE factures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(50) NOT NULL UNIQUE,
    date DATE NOT NULL,
    client VARCHAR(100) NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    statut ENUM('brouillon','envoyee','payee','annulee') DEFAULT 'brouillon',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Paiements (Finance)
CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    facture_id INT NOT NULL,
    date DATE NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    methode ENUM('virement','carte','especes','autre') DEFAULT 'virement',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (facture_id) REFERENCES factures(id) ON DELETE CASCADE
);

-- Relevés Bancaires (Finance)
CREATE TABLE releves_bancaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    solde DECIMAL(12,2) NOT NULL,
    fichier VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tâches (Projets)
CREATE TABLE taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    responsable_id INT,
    statut ENUM('a_faire','en_cours','terminee','bloquee') DEFAULT 'a_faire',
    echeance DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (responsable_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Jalons (Projets)
CREATE TABLE jalons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Risques (Projets)
CREATE TABLE risques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    description TEXT NOT NULL,
    niveau ENUM('faible','moyen','eleve') DEFAULT 'moyen',
    plan_action TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Contacts (CRM)
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('donateur','partenaire','membre','beneficiaire','autre') DEFAULT 'autre',
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(20),
    organisation VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Interactions (CRM)
CREATE TABLE interactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    type ENUM('appel','email','reunion','note','autre') DEFAULT 'autre',
    date DATETIME NOT NULL,
    description TEXT,
    utilisateur_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Campagnes (CRM)
CREATE TABLE campagnes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    type ENUM('email','sms','autre') DEFAULT 'email',
    date_lancement DATE,
    statut ENUM('brouillon','active','terminee') DEFAULT 'brouillon',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Engagements (CRM)
CREATE TABLE engagements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    campagne_id INT,
    montant DECIMAL(12,2),
    date DATE,
    statut ENUM('promesse','recu','annule') DEFAULT 'promesse',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (campagne_id) REFERENCES campagnes(id) ON DELETE SET NULL
);

-- Documents (GED)
CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    chemin VARCHAR(255) NOT NULL,
    type VARCHAR(50),
    version VARCHAR(20),
    statut ENUM('actif','archive','supprime') DEFAULT 'actif',
    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    utilisateur_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Politiques de Confidentialité (Conformité)
CREATE TABLE politiques_confidentialite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(20) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Audit Trail (Conformité)
CREATE TABLE audit_trail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE SET NULL
);