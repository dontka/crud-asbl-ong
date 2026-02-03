-- HR Module Tables
-- Migration: Create HR Management System Tables

USE crud_asbl_ong;

-- Employees Table (Dossiers du personnel)
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    birth_date DATE,
    gender ENUM('M', 'F', 'Other') DEFAULT 'Other',
    nationality VARCHAR(50),
    address TEXT,
    city VARCHAR(50),
    postal_code VARCHAR(10),
    country VARCHAR(50),
    
    -- Employment Information
    employee_number VARCHAR(50) UNIQUE,
    position VARCHAR(100),
    department VARCHAR(100),
    hire_date DATE NOT NULL,
    employment_status ENUM('active', 'on_leave', 'suspended', 'terminated') DEFAULT 'active',
    employment_type ENUM('CDI', 'CDD', 'Stage', 'Alternance', 'Freelance') DEFAULT 'CDI',
    manager_id INT,
    
    -- Compensation
    salary_gross DECIMAL(10, 2),
    currency VARCHAR(3) DEFAULT 'EUR',
    
    -- Documents & Status
    social_security_number VARCHAR(50),
    tax_id VARCHAR(50),
    documents_path TEXT,
    notes TEXT,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (manager_id) REFERENCES employees(id) ON DELETE SET NULL,
    INDEX (department),
    INDEX (employment_status),
    INDEX (hire_date)
);

-- Contracts Table (Gestion des contrats)
CREATE TABLE IF NOT EXISTS contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    contract_type ENUM('CDI', 'CDD', 'Stage', 'Alternance', 'Freelance') NOT NULL,
    contract_number VARCHAR(50) UNIQUE,
    start_date DATE NOT NULL,
    end_date DATE,
    renewal_date DATE,
    status ENUM('active', 'ended', 'renewed', 'terminated') DEFAULT 'active',
    position_title VARCHAR(100),
    salary DECIMAL(10, 2),
    working_hours INT DEFAULT 35,
    probation_period_days INT,
    probation_end_date DATE,
    
    -- Document
    document_path TEXT,
    notes TEXT,
    
    -- Alerts
    alert_renewal BOOLEAN DEFAULT FALSE,
    alert_renewal_date DATE,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX (start_date),
    INDEX (end_date),
    INDEX (status)
);

-- Absences & Leave Table (Gestion des absences et congés)
CREATE TABLE IF NOT EXISTS absences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    absence_type ENUM('Congé', 'Maladie', 'Absence Justifiée', 'Absence Non Justifiée', 'Télétravail', 'Formations') DEFAULT 'Congé',
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    duration_days INT,
    status ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
    reason TEXT,
    manager_id INT,
    approval_date TIMESTAMP NULL,
    approval_comments TEXT,
    attachment_path TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (manager_id) REFERENCES employees(id) ON DELETE SET NULL,
    INDEX (status),
    INDEX (start_date),
    INDEX (employee_id)
);

-- Leave Balance Table (Suivi des droits à congés)
CREATE TABLE IF NOT EXISTS leave_balances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL UNIQUE,
    year INT NOT NULL,
    annual_leave_days INT DEFAULT 25,
    taken_leave_days DECIMAL(8, 2) DEFAULT 0,
    remaining_leave_days DECIMAL(8, 2),
    sick_leave_days INT DEFAULT 0,
    other_leave_days INT DEFAULT 0,
    
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_employee_year (employee_id, year)
);

-- Timekeeping/Pointage Table (Gestion du pointage)
CREATE TABLE IF NOT EXISTS timekeeping (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    check_in TIME,
    check_out TIME,
    worked_hours DECIMAL(5, 2),
    overtime_hours DECIMAL(5, 2) DEFAULT 0,
    status ENUM('present', 'absent', 'late', 'half_day', 'on_leave') DEFAULT 'present',
    notes TEXT,
    validated BOOLEAN DEFAULT FALSE,
    validated_by INT,
    validated_at TIMESTAMP NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (validated_by) REFERENCES employees(id) ON DELETE SET NULL,
    UNIQUE KEY unique_employee_date (employee_id, date),
    INDEX (date),
    INDEX (status)
);

-- Skills/Competences Table (Gestion des compétences)
CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    category VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Employee Skills Table (Compétences des employés)
CREATE TABLE IF NOT EXISTS employee_skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    skill_id INT NOT NULL,
    proficiency_level ENUM('Novice', 'Intermédiaire', 'Expert', 'Master') DEFAULT 'Intermédiaire',
    acquired_date DATE,
    expiry_date DATE,
    notes TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE,
    UNIQUE KEY unique_employee_skill (employee_id, skill_id)
);

-- Trainings Table (Gestion des formations)
CREATE TABLE IF NOT EXISTS trainings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    provider VARCHAR(100),
    description TEXT,
    training_type ENUM('Interne', 'Externe', 'Online', 'Conférence') DEFAULT 'Externe',
    start_date DATE NOT NULL,
    end_date DATE,
    duration_hours INT,
    location VARCHAR(200),
    cost DECIMAL(10, 2),
    max_participants INT,
    status ENUM('planned', 'ongoing', 'completed', 'cancelled') DEFAULT 'planned',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (start_date)
);

-- Employee Trainings Table (Participations aux formations)
CREATE TABLE IF NOT EXISTS employee_trainings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    training_id INT NOT NULL,
    status ENUM('registered', 'attended', 'absent', 'cancelled') DEFAULT 'registered',
    score INT,
    certification_obtained BOOLEAN DEFAULT FALSE,
    certification_date DATE,
    certification_expiry DATE,
    notes TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (training_id) REFERENCES trainings(id) ON DELETE CASCADE,
    UNIQUE KEY unique_employee_training (employee_id, training_id)
);

-- Evaluations Table (Évaluations annuelles)
CREATE TABLE IF NOT EXISTS evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    evaluator_id INT,
    evaluation_year INT NOT NULL,
    evaluation_period VARCHAR(50),
    evaluation_date DATE,
    
    -- Scores (1-5 scale)
    job_knowledge INT,
    performance INT,
    teamwork INT,
    communication INT,
    initiative INT,
    attendance INT,
    overall_score INT,
    
    -- Comments
    strengths TEXT,
    improvements TEXT,
    career_goals TEXT,
    general_comments TEXT,
    
    status ENUM('draft', 'submitted', 'reviewed', 'finalized') DEFAULT 'draft',
    next_review_date DATE,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (evaluator_id) REFERENCES employees(id) ON DELETE SET NULL,
    UNIQUE KEY unique_employee_year_evaluation (employee_id, evaluation_year),
    INDEX (evaluation_date)
);

-- Payroll Table (Bulletins de paie)
CREATE TABLE IF NOT EXISTS payroll (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    payroll_month INT,
    payroll_year INT,
    salary_gross DECIMAL(10, 2),
    bonuses DECIMAL(10, 2) DEFAULT 0,
    deductions DECIMAL(10, 2) DEFAULT 0,
    taxes DECIMAL(10, 2) DEFAULT 0,
    social_contributions DECIMAL(10, 2) DEFAULT 0,
    salary_net DECIMAL(10, 2),
    overtime_hours DECIMAL(5, 2),
    overtime_pay DECIMAL(10, 2),
    status ENUM('draft', 'validated', 'paid', 'cancelled') DEFAULT 'draft',
    payment_date DATE,
    payment_method VARCHAR(50),
    notes TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_employee_payroll (employee_id, payroll_month, payroll_year),
    INDEX (payroll_year)
);

-- Recruitment Offers Table (Offres d'emploi)
CREATE TABLE IF NOT EXISTS recruitment_offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    department VARCHAR(100),
    position_type VARCHAR(100),
    contract_type ENUM('CDI', 'CDD', 'Stage', 'Alternance', 'Freelance') DEFAULT 'CDI',
    salary_range_min DECIMAL(10, 2),
    salary_range_max DECIMAL(10, 2),
    requirements TEXT,
    location VARCHAR(200),
    posting_date DATE,
    closing_date DATE,
    status ENUM('draft', 'open', 'closed', 'archived') DEFAULT 'draft',
    created_by INT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (created_by) REFERENCES employees(id) ON DELETE SET NULL,
    INDEX (status),
    INDEX (closing_date)
);

-- Recruitment Candidates Table (Candidats)
CREATE TABLE IF NOT EXISTS recruitment_candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    offer_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    cv_path TEXT,
    cover_letter_path TEXT,
    application_date DATE,
    status ENUM('new', 'screening', 'interview', 'offer', 'rejected', 'hired') DEFAULT 'new',
    score INT,
    notes TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (offer_id) REFERENCES recruitment_offers(id) ON DELETE CASCADE,
    INDEX (status),
    INDEX (application_date)
);

-- Interviews Table (Entretiens)
CREATE TABLE IF NOT EXISTS interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT NOT NULL,
    interviewer_id INT,
    interview_date DATETIME,
    interview_type ENUM('Phone', 'In-Person', 'Video', 'Group') DEFAULT 'In-Person',
    feedback TEXT,
    rating INT,
    next_step VARCHAR(255),
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (candidate_id) REFERENCES recruitment_candidates(id) ON DELETE CASCADE,
    FOREIGN KEY (interviewer_id) REFERENCES employees(id) ON DELETE SET NULL,
    INDEX (interview_date)
);

-- HR Policies Table (Politiques RH)
CREATE TABLE IF NOT EXISTS hr_policies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    content TEXT,
    effective_date DATE,
    version INT DEFAULT 1,
    active BOOLEAN DEFAULT TRUE,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create Indexes for better performance
CREATE INDEX idx_employees_user_id ON employees(user_id);
CREATE INDEX idx_employees_department ON employees(department);
CREATE INDEX idx_employees_employment_status ON employees(employment_status);
CREATE INDEX idx_contracts_employee_id ON contracts(employee_id);
CREATE INDEX idx_absences_employee_id ON absences(employee_id);
CREATE INDEX idx_timekeeping_employee_id ON timekeeping(employee_id);
CREATE INDEX idx_employee_skills_employee_id ON employee_skills(employee_id);
CREATE INDEX idx_employee_trainings_employee_id ON employee_trainings(employee_id);
CREATE INDEX idx_evaluations_employee_id ON evaluations(employee_id);
CREATE INDEX idx_payroll_employee_id ON payroll(employee_id);

-- Insert some sample skills for the system
INSERT INTO skills (name, category, description) VALUES
('PHP', 'Programming', 'Backend web development'),
('JavaScript', 'Programming', 'Frontend web development'),
('Project Management', 'Management', 'Project planning and execution'),
('Communication', 'Soft Skills', 'Interpersonal communication'),
('Leadership', 'Management', 'Team leadership and direction'),
('SQL', 'Database', 'Database management and queries'),
('Team Work', 'Soft Skills', 'Collaboration and teamwork'),
('Problem Solving', 'Soft Skills', 'Analytical and problem-solving skills'),
('Customer Service', 'Soft Skills', 'Customer support and service excellence'),
('Financial Management', 'Finance', 'Budget and financial management')
ON DUPLICATE KEY UPDATE id=id;
