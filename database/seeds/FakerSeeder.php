<?php

/**
 * Faker Seeder - Génère des données fictives pour tester l'application
 * Utilise la bibliothèque Faker pour créer :
 * - Utilisateurs fictifs
 * - Employés fictifs
 * - Contrats fictifs
 * - Absences fictives
 * - Donations fictives
 * - Projets fictifs
 * - Événements fictifs
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Faker\Factory as Faker;

class FakerSeeder
{
    private $faker;
    private $pdo;
    private $db;

    public function __construct()
    {
        $this->faker = Faker::create('fr_FR');

        // Connexion à la base de données
        require_once __DIR__ . '/../../models/Database.php';
        $this->db = Database::getInstance();
        $this->pdo = $this->db->getConnection();
        $this->db->selectDatabase(DB_NAME);
    }

    /**
     * Exécute tous les seeders
     */
    public function seed()
    {
        echo "🌱 Début du seeding des données fictives...\n\n";

        try {
            $this->seedUsers();
            $this->seedEmployees();
            $this->seedContracts();
            $this->seedAbsences();
            $this->seedMembers();
            $this->seedProjects();
            $this->seedEvents();
            $this->seedDonations();

            echo "\n✅ Seeding terminé avec succès !\n";
        } catch (Exception $e) {
            echo "❌ Erreur lors du seeding: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * Exécute les seeders sélectionnés avec les quantités personnalisées
     * @param array $types Types de données à générer (users, employees, contracts, etc.)
     * @param array $quantities Quantités pour chaque type
     */
    public function seedSelective($types = [], $quantities = [])
    {
        echo "🌱 Début du seeding des données fictives...\n\n";

        try {
            // Définir les quantités par défaut
            $defaultQuantities = [
                'users' => 15,
                'employees' => 25,
                'contracts' => 30,
                'absences' => 40,
                'members' => 50,
                'projects' => 12,
                'events' => 15,
                'donations' => 60
            ];

            // Fusionner avec les quantités fournies
            $quantities = array_merge($defaultQuantities, $quantities);

            // Générer les données sélectionnées
            if (in_array('users', $types)) {
                $this->seedUsers($quantities['users']);
            }
            if (in_array('employees', $types)) {
                $this->seedEmployees($quantities['employees']);
            }
            if (in_array('contracts', $types)) {
                $this->seedContracts($quantities['contracts']);
            }
            if (in_array('absences', $types)) {
                $this->seedAbsences($quantities['absences']);
            }
            if (in_array('members', $types)) {
                $this->seedMembers($quantities['members']);
            }
            if (in_array('projects', $types)) {
                $this->seedProjects($quantities['projects']);
            }
            if (in_array('events', $types)) {
                $this->seedEvents($quantities['events']);
            }
            if (in_array('donations', $types)) {
                $this->seedDonations($quantities['donations']);
            }

            echo "\n✅ Seeding terminé avec succès !\n";
        } catch (Exception $e) {
            echo "❌ Erreur lors du seeding: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * Génère des utilisateurs fictifs
     */
    private function seedUsers($count = 15)
    {
        echo "📝 Génération des utilisateurs fictifs...\n";

        $roles = ['admin', 'manager', 'employee', 'member'];

        for ($i = 1; $i <= $count; $i++) {
            $firstName = $this->faker->firstName();
            $lastName = $this->faker->lastName();
            $email = strtolower($firstName . '.' . $lastName . '@asbl-ong.test');

            $stmt = $this->pdo->prepare("
                INSERT INTO users (first_name, last_name, email, password, role, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE email=VALUES(email)
            ");

            $hashedPassword = password_hash('password123', PASSWORD_BCRYPT);
            $role = $roles[array_rand($roles)];

            $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $role, 'active']);
        }

        echo "   ✓ $count utilisateurs créés\n";
    }

    /**
     * Génère des employés fictifs
     */
    private function seedEmployees($count = 25)
    {
        echo "👥 Génération des employés fictifs...\n";

        $positions = ['Developer', 'Designer', 'Manager', 'Coordinator', 'Analyst', 'Consultant', 'Director'];
        $employmentTypes = ['full-time', 'part-time', 'contract', 'intern'];

        for ($i = 1; $i <= $count; $i++) {
            $firstName = $this->faker->firstName();
            $lastName = $this->faker->lastName();
            $email = strtolower($firstName . '.' . $lastName . '@employees.asbl-ong.test');

            $stmt = $this->pdo->prepare("
                INSERT INTO employees (first_name, last_name, email, phone, birth_date, gender, employee_number, position, 
                    employment_type, employment_status, hire_date, salary_gross, address, city, postal_code, country, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE email=VALUES(email)
            ");

            $hireDate = $this->faker->dateTimeBetween('-5 years', 'now');
            $birthDate = $this->faker->dateTimeBetween('-60 years', '-20 years');
            $salary = $this->faker->numberBetween(28000, 85000);

            $stmt->execute([
                $firstName,
                $lastName,
                $email,
                $this->faker->phoneNumber(),
                $birthDate->format('Y-m-d'),
                $this->faker->randomElement(['male', 'female', 'other']),
                'EMP-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                $positions[array_rand($positions)],
                $employmentTypes[array_rand($employmentTypes)],
                'active',
                $hireDate->format('Y-m-d'),
                $salary,
                $this->faker->streetAddress(),
                $this->faker->city(),
                $this->faker->postcode(),
                'Belgium',
            ]);
        }

        echo "   ✓ $count employés créés\n";
    }

    /**
     * Génère des contrats fictifs
     */
    private function seedContracts($count = 30)
    {
        echo "📋 Génération des contrats fictifs...\n";

        $contractTypes = ['CDI', 'CDD', 'Stage', 'Temporaire', 'Freelance'];
        $statuses = ['active', 'inactive', 'ended'];

        // Récupère les IDs des employés
        $employees = $this->pdo->query("SELECT id FROM employees LIMIT 25")->fetchAll(PDO::FETCH_COLUMN);

        for ($i = 1; $i <= $count && $i <= count($employees); $i++) {
            $employeeId = $employees[array_rand($employees)];
            $contractType = $contractTypes[array_rand($contractTypes)];
            $startDate = $this->faker->dateTimeBetween('-3 years', 'now');
            $probationDays = $this->faker->randomElement([30, 60, 90]);
            $probationEndDate = (clone $startDate)->modify("+$probationDays days");

            $endDate = null;
            if ($contractType !== 'CDI') {
                $endDate = $this->faker->dateTimeBetween($startDate, '+5 years');
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO contracts (employee_id, contract_type, contract_number, start_date, end_date, 
                    renewal_date, probation_end_date, position_title, salary, working_hours, 
                    probation_period_days, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE employee_id=VALUES(employee_id)
            ");

            $stmt->execute([
                $employeeId,
                $contractType,
                'CTR-' . date('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                $startDate->format('Y-m-d'),
                $endDate ? $endDate->format('Y-m-d') : null,
                $this->faker->optional(0.3)->dateTimeBetween($startDate, '+10 years')?->format('Y-m-d'),
                $probationEndDate->format('Y-m-d'),
                $this->faker->jobTitle(),
                $this->faker->numberBetween(30000, 75000),
                $this->faker->randomElement([35, 37.5, 40]),
                $probationDays,
                $statuses[array_rand($statuses)],
            ]);
        }

        echo "   ✓ $count contrats créés\n";
    }

    /**
     * Génère des absences fictives
     */
    private function seedAbsences($count = 40)
    {
        echo "🚫 Génération des absences fictives...\n";

        $types = ['vacation', 'sick_leave', 'personal', 'unpaid_leave', 'training'];
        $statuses = ['approved', 'rejected', 'pending'];

        // Récupère les IDs des employés
        $employees = $this->pdo->query("SELECT id FROM employees LIMIT 20")->fetchAll(PDO::FETCH_COLUMN);

        for ($i = 1; $i <= $count; $i++) {
            $employeeId = $employees[array_rand($employees)];
            $startDate = $this->faker->dateTimeBetween('-6 months', '+2 months');
            $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 15) . ' days');

            $stmt = $this->pdo->prepare("
                INSERT INTO absences (employee_id, absence_type, start_date, end_date, reason, 
                    status, approver_id, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->execute([
                $employeeId,
                $types[array_rand($types)],
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
                $this->faker->sentence(),
                $statuses[array_rand($statuses)],
                $this->faker->optional(0.7)->numberBetween(1, 5),
            ]);
        }

        echo "   ✓ $count absences créées\n";
    }

    /**
     * Génère des membres fictifs
     */
    private function seedMembers($count = 50)
    {
        echo "👫 Génération des membres fictifs...\n";

        $memberTypes = ['donor', 'volunteer', 'partner', 'beneficiary'];

        for ($i = 1; $i <= $count; $i++) {
            $firstName = $this->faker->firstName();
            $lastName = $this->faker->lastName();

            $stmt = $this->pdo->prepare("
                INSERT INTO members (first_name, last_name, email, phone, member_type, 
                    membership_date, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE email=VALUES(email)
            ");

            $stmt->execute([
                $firstName,
                $lastName,
                $this->faker->unique()->safeEmail(),
                $this->faker->optional(0.7)->phoneNumber(),
                $memberTypes[array_rand($memberTypes)],
                $this->faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
                $this->faker->randomElement(['active', 'inactive']),
            ]);
        }

        echo "   ✓ $count membres créés\n";
    }

    /**
     * Génère des projets fictifs
     */
    private function seedProjects($count = 12)
    {
        echo "📊 Génération des projets fictifs...\n";

        $statuses = ['planning', 'in_progress', 'on_hold', 'completed', 'archived'];

        for ($i = 1; $i <= $count; $i++) {
            $startDate = $this->faker->dateTimeBetween('-12 months', 'now');
            $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(3, 24) . ' months');

            $stmt = $this->pdo->prepare("
                INSERT INTO projects (name, description, start_date, end_date, status, 
                    budget, progress, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->execute([
                $this->faker->catchPhrase(),
                $this->faker->paragraph(3),
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
                $statuses[array_rand($statuses)],
                $this->faker->numberBetween(10000, 500000),
                $this->faker->numberBetween(0, 100),
            ]);
        }

        echo "   ✓ $count projets créés\n";
    }

    /**
     * Génère des événements fictifs
     */
    private function seedEvents($count = 15)
    {
        echo "🎉 Génération des événements fictifs...\n";

        $types = ['conference', 'workshop', 'meeting', 'training', 'celebration', 'networking'];

        for ($i = 1; $i <= $count; $i++) {
            $eventDate = $this->faker->dateTimeBetween('now', '+12 months');
            $startTime = $this->faker->time('H:i');
            $endTime = $this->faker->time('H:i');

            $stmt = $this->pdo->prepare("
                INSERT INTO events (title, description, event_type, event_date, start_time, 
                    end_time, location, attendees_count, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->execute([
                $this->faker->sentence(4),
                $this->faker->paragraph(2),
                $types[array_rand($types)],
                $eventDate->format('Y-m-d'),
                $startTime,
                $endTime,
                $this->faker->city(),
                $this->faker->numberBetween(10, 500),
                $this->faker->randomElement(['planned', 'in_progress', 'completed', 'cancelled']),
            ]);
        }

        echo "   ✓ $count événements créés\n";
    }

    /**
     * Génère des donations fictives
     */
    private function seedDonations($count = 60)
    {
        echo "💰 Génération des donations fictives...\n";

        $currencies = ['EUR', 'USD'];
        $statuses = ['received', 'pending', 'cancelled'];

        // Récupère les IDs des membres
        $members = $this->pdo->query("SELECT id FROM members LIMIT 30")->fetchAll(PDO::FETCH_COLUMN);

        for ($i = 1; $i <= $count; $i++) {
            $memberId = $members[array_rand($members)] ?? null;

            $stmt = $this->pdo->prepare("
                INSERT INTO donations (member_id, amount, currency, donation_date, 
                    description, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->execute([
                $memberId,
                $this->faker->numberBetween(25, 5000),
                $currencies[array_rand($currencies)],
                $this->faker->dateTimeBetween('-12 months', 'now')->format('Y-m-d'),
                $this->faker->optional(0.6)->sentence(),
                $statuses[array_rand($statuses)],
            ]);
        }

        echo "   ✓ $count donations créées\n";
    }
}

// Exécution du seeder
if (php_sapi_name() === 'cli') {
    $seeder = new FakerSeeder();
    $seeder->seed();
}
