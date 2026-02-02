-- Additional Test Data for Advanced Modules
USE crud_asbl_ong;

-- Insert Test Employes (RH)
INSERT INTO employes (user_id, first_name, last_name, email, phone, address, hire_date, status) VALUES
(1, 'Alice', 'Johnson', 'alice.johnson@asbl-ong.org', '+32 111 222 333', 'Rue du Travail 1, Brussels', '2022-01-15', 'active'),
(2, 'Bob', 'Smith', 'bob.smith@asbl-ong.org', '+32 444 555 666', 'Avenue des Employés 2, Brussels', '2022-03-20', 'active'),
(3, 'Claire', 'Davis', 'claire.davis@asbl-ong.org', '+32 777 888 999', 'Place du Bureau 3, Brussels', '2022-05-10', 'active');

-- Insert Test Contrats (RH)
INSERT INTO contrats (employe_id, type, start_date, end_date, status) VALUES
(1, 'CDI', '2022-01-15', NULL, 'actif'),
(2, 'CDD', '2022-03-20', '2024-03-20', 'actif'),
(3, 'CDI', '2022-05-10', NULL, 'actif');

-- Insert Test Absences (RH)
INSERT INTO absences (employe_id, type, start_date, end_date, status) VALUES
(1, 'conge', '2023-12-20', '2023-12-25', 'valide'),
(2, 'maladie', '2023-11-15', '2023-11-17', 'valide');

-- Insert Test Pointages (RH)
INSERT INTO pointages (employe_id, date, heures, type) VALUES
(1, '2023-12-01', 8.0, 'travail'),
(1, '2023-12-02', 8.0, 'travail'),
(2, '2023-12-01', 7.5, 'travail'),
(3, '2023-12-01', 8.0, 'travail');

-- Insert Test Budgets (Finance)
INSERT INTO budgets (project_id, name, amount, currency, period) VALUES
(1, 'Budget Environnement 2023', 5000.00, 'EUR', '2023'),
(2, 'Budget Aide Alimentaire 2023', 10000.00, 'EUR', '2023'),
(3, 'Budget Éducation 2023', 7500.00, 'EUR', '2023');

-- Insert Test Factures (Finance)
INSERT INTO factures (numero, date, client, montant, statut) VALUES
('F2023-001', '2023-10-01', 'Fournisseur A', 1200.00, 'payee'),
('F2023-002', '2023-10-15', 'Fournisseur B', 800.00, 'envoyee'),
('F2023-003', '2023-11-01', 'Fournisseur C', 1500.00, 'brouillon');

-- Insert Test Relevés Bancaires (Finance)
INSERT INTO releves_bancaires (date, solde, fichier) VALUES
('2023-12-01', 25000.00, 'releve_dec_2023.pdf'),
('2023-11-01', 22000.00, 'releve_nov_2023.pdf');

-- Insert Test Tâches (Projets)
INSERT INTO taches (project_id, titre, description, responsable_id, statut, echeance) VALUES
(1, 'Campagne de sensibilisation', 'Créer les supports de communication', 1, 'en_cours', '2023-12-15'),
(1, 'Partenariats écoles', 'Contacter les écoles locales', 2, 'a_faire', '2023-12-20'),
(2, 'Distribution alimentaire', 'Organiser la logistique', 1, 'en_cours', '2024-01-10'),
(3, 'Sessions d\'alphabétisation', 'Préparer le programme', 3, 'terminee', '2023-11-30');

-- Insert Test Risques (Projets)
INSERT INTO risques (project_id, description, niveau, plan_action) VALUES
(1, 'Manque de participants', 'moyen', 'Campagne marketing supplémentaire'),
(2, 'Retard livraison nourriture', 'eleve', 'Diversifier les fournisseurs');

-- Insert Test Contacts (CRM)
INSERT INTO contacts (type, nom, email, telephone, organisation) VALUES
('donateur', 'Jean Dupont', 'jean.dupont@email.com', '+32 123 456 789', 'Particulier'),
('partenaire', 'ONG Verte', 'contact@ongverte.be', '+32 987 654 321', 'ONG Verte'),
('beneficiaire', 'Marie Curie', 'marie.curie@email.com', '+32 555 123 456', 'Particulier'),
('membre', 'Pierre Dubois', 'pierre.dubois@email.com', '+32 444 789 012', 'Membre actif');

-- Insert Test Campagnes (CRM)
INSERT INTO campagnes (nom, type, date_lancement, statut) VALUES
('Campagne Noël 2023', 'email', '2023-12-01', 'active'),
('Newsletter mensuelle', 'email', '2023-11-01', 'active');

-- Insert Test Engagements (CRM)
INSERT INTO engagements (contact_id, campagne_id, montant, date, statut) VALUES
(1, 1, 100.00, '2023-12-01', 'promesse'),
(3, 1, 50.00, '2023-12-02', 'recu');

-- Insert Test Documents (GED)
INSERT INTO documents (nom, chemin, type, version, statut, utilisateur_id) VALUES
('Statuts ASBL', '/documents/statuts.pdf', 'PDF', '1.0', 'actif', 1),
('Rapport Annuel 2023', '/documents/rapport_2023.pdf', 'PDF', '1.0', 'actif', 1),
('Budget 2024', '/documents/budget_2024.xlsx', 'XLSX', '1.0', 'actif', 2);

-- Insert Test Audit Trail (Conformité)
INSERT INTO audit_trail (utilisateur_id, action, description, date) VALUES
(1, 'LOGIN', 'Connexion administrateur', '2023-12-01 09:00:00'),
(1, 'CREATE_PROJECT', 'Création du projet Environnement', '2023-12-01 10:30:00'),
(2, 'UPDATE_MEMBER', 'Modification données membre', '2023-12-01 11:15:00');