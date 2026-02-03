<?php

/**
 * Interactive CLI Menu for Faker Data Seeder
 * 
 * Usage: php seed-menu.php
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/config.php';

use Faker\Factory as Faker;

class SeederMenu
{
    protected $faker;
    protected $db;

    public function __construct()
    {
        $this->faker = Faker::create('fr_FR');
        $this->db = Database::getInstance();
    }

    /**
     * Display main menu
     */
    public function showMenu()
    {
        while (true) {
            $this->clearScreen();
            echo "\n";
            echo "╔═══════════════════════════════════════════════════════╗\n";
            echo "║       FAKER DATA SEEDER - MENU INTERACTIF            ║\n";
            echo "╚═══════════════════════════════════════════════════════╝\n\n";

            echo "Veuillez sélectionner une option:\n\n";
            echo "  1) Générer utilisateurs fictifs\n";
            echo "  2) Générer employés fictifs\n";
            echo "  3) Générer contrats fictifs\n";
            echo "  4) Générer TOUTES les données\n";
            echo "  5) Afficher statistiques de la base de données\n";
            echo "  6) Vider les données de test\n";
            echo "  0) Quitter\n\n";

            echo "Votre choix: ";
            $choice = trim(fgets(STDIN));

            switch ($choice) {
                case '1':
                    $this->seedUsers();
                    break;
                case '2':
                    $this->seedEmployees();
                    break;
                case '3':
                    $this->seedContracts();
                    break;
                case '4':
                    $this->seedAll();
                    break;
                case '5':
                    $this->showStatistics();
                    break;
                case '6':
                    $this->truncateData();
                    break;
                case '0':
                    echo "\n👋 Au revoir!\n\n";
                    exit(0);
                default:
                    echo "\n❌ Option invalide. Veuillez réessayer.\n";
            }

            echo "\nAppuyez sur ENTRÉE pour continuer...";
            fgets(STDIN);
        }
    }

    /**
     * Clear screen
     */
    private function clearScreen()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }

    /**
     * Generate fake users
     */
    private function seedUsers()
    {
        echo "\n🔄 Génération d'utilisateurs fictifs...\n";

        $count = 15;
        $roles = ['admin', 'moderator', 'hr_manager', 'user', 'volunteer'];

        try {
            $inserted = 0;
            for ($i = 0; $i < $count; $i++) {
                $firstName = $this->faker->firstName();
                $lastName = $this->faker->lastName();
                $email = strtolower(str_replace(' ', '.', $firstName . '.' . $lastName . '@' . $this->faker->domainName()));

                $data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'password' => password_hash('password123', PASSWORD_BCRYPT),
                    'phone' => $this->faker->phoneNumber(),
                    'role' => $roles[array_rand($roles)],
                    'status' => $this->faker->randomElement(['active', 'inactive']),
                    'created_at' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                ];

                try {
                    $stmt = $this->db->getConnection()->prepare(
                        "INSERT INTO users (first_name, last_name, email, password, phone, role, status, created_at) 
                         VALUES (:first_name, :last_name, :email, :password, :phone, :role, :status, :created_at)"
                    );
                    $stmt->execute($data);
                    $inserted++;
                } catch (\Exception $e) {
                    // Continue if email already exists
                    continue;
                }
            }

            echo "✅ $inserted utilisateurs créés avec succès!\n";
        } catch (\Exception $e) {
            echo "❌ Erreur: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Generate fake employees
     */
    private function seedEmployees()
    {
        echo "\n🔄 Génération d'employés fictifs...\n";

        $count = 20;
        $departments = ['HR', 'Finance', 'IT', 'Operations', 'Management', 'Marketing', 'Support', 'Development'];
        $positions = ['Manager', 'Developer', 'Analyst', 'Officer', 'Coordinator', 'Specialist', 'Technician', 'Administrator'];

        try {
            $inserted = 0;
            for ($i = 0; $i < $count; $i++) {
                $firstName = $this->faker->firstName();
                $lastName = $this->faker->lastName();

                $data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => strtolower($firstName . '.' . $lastName . '@company.com'),
                    'phone' => $this->faker->phoneNumber(),
                    'birth_date' => $this->faker->dateOfBirth('1960-01-01', '2005-12-31')->format('Y-m-d'),
                    'hire_date' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
                    'department' => $departments[array_rand($departments)],
                    'position' => $positions[array_rand($positions)],
                    'salary' => $this->faker->numberBetween(25000, 80000),
                    'employment_status' => $this->faker->randomElement(['active', 'inactive', 'on_leave']),
                    'address' => $this->faker->streetAddress(),
                    'city' => $this->faker->city(),
                    'postal_code' => $this->faker->postcode(),
                    'country' => 'Belgium',
                    'created_at' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                ];

                try {
                    $stmt = $this->db->getConnection()->prepare(
                        "INSERT INTO employees (first_name, last_name, email, phone, birth_date, hire_date, department, position, salary, employment_status, address, city, postal_code, country, created_at) 
                         VALUES (:first_name, :last_name, :email, :phone, :birth_date, :hire_date, :department, :position, :salary, :employment_status, :address, :city, :postal_code, :country, :created_at)"
                    );
                    $stmt->execute($data);
                    $inserted++;
                } catch (\Exception $e) {
                    continue;
                }
            }

            echo "✅ $inserted employés créés avec succès!\n";
        } catch (\Exception $e) {
            echo "❌ Erreur: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Generate fake contracts
     */
    private function seedContracts()
    {
        echo "\n🔄 Génération de contrats fictifs...\n";

        $count = 25;
        $contractTypes = ['CDI', 'CDD', 'Stage', 'Temporaire', 'Freelance'];
        $statuses = ['active', 'inactive', 'ended'];

        try {
            // Get active employees
            $employees = $this->db->query("SELECT id FROM employees WHERE employment_status = 'active' LIMIT 20")->fetchAll();

            if (empty($employees)) {
                echo "⚠️  Aucun employé actif trouvé. Veuillez d'abord générer des employés.\n";
                return;
            }

            $inserted = 0;
            for ($i = 0; $i < min($count, count($employees)); $i++) {
                $employeeId = $employees[$i]['id'];
                $startDate = $this->faker->dateTimeBetween('-5 years', 'now');
                $contractType = $contractTypes[array_rand($contractTypes)];
                $endDate = ($contractType === 'CDI') ? null : $this->faker->dateTimeBetween($startDate, '+5 years');
                $probationDays = $this->faker->randomElement([30, 60, 90, 120]);
                $probationEndDate = (clone $startDate)->modify("+{$probationDays} days");

                $data = [
                    'employee_id' => $employeeId,
                    'contract_type' => $contractType,
                    'contract_number' => 'CTR-' . date('Y') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
                    'renewal_date' => $this->faker->optional(0.4)->dateTimeThisYear()->format('Y-m-d'),
                    'probation_end_date' => $probationEndDate->format('Y-m-d'),
                    'status' => $statuses[array_rand($statuses)],
                    'position_title' => $this->faker->jobTitle(),
                    'salary' => $this->faker->numberBetween(28000, 75000),
                    'working_hours' => $this->faker->randomElement([35, 37.5, 40]),
                    'probation_period_days' => $probationDays,
                    'notes' => $this->faker->optional(0.6)->paragraph(),
                    'created_at' => $startDate->format('Y-m-d H:i:s'),
                ];

                try {
                    $stmt = $this->db->getConnection()->prepare(
                        "INSERT INTO contracts (employee_id, contract_type, contract_number, start_date, end_date, renewal_date, probation_end_date, status, position_title, salary, working_hours, probation_period_days, notes, created_at) 
                         VALUES (:employee_id, :contract_type, :contract_number, :start_date, :end_date, :renewal_date, :probation_end_date, :status, :position_title, :salary, :working_hours, :probation_period_days, :notes, :created_at)"
                    );
                    $stmt->execute($data);
                    $inserted++;
                } catch (\Exception $e) {
                    continue;
                }
            }

            echo "✅ $inserted contrats créés avec succès!\n";
        } catch (\Exception $e) {
            echo "❌ Erreur: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Generate all data
     */
    private function seedAll()
    {
        echo "\n🔄 Génération de TOUTES les données fictives...\n\n";
        $this->seedUsers();
        $this->seedEmployees();
        $this->seedContracts();
    }

    /**
     * Show database statistics
     */
    private function showStatistics()
    {
        echo "\n📊 STATISTIQUES DE LA BASE DE DONNÉES\n";
        echo "════════════════════════════════════════\n\n";

        try {
            $userCount = $this->db->query("SELECT COUNT(*) as count FROM users")->fetch()['count'];
            $employeeCount = $this->db->query("SELECT COUNT(*) as count FROM employees")->fetch()['count'];
            $contractCount = $this->db->query("SELECT COUNT(*) as count FROM contracts")->fetch()['count'];

            echo "👥 Utilisateurs: $userCount\n";
            echo "👨‍💼 Employés: $employeeCount\n";
            echo "📄 Contrats: $contractCount\n";

            // Additional stats
            $activeEmployees = $this->db->query("SELECT COUNT(*) as count FROM employees WHERE employment_status = 'active'")->fetch()['count'];
            $activeContracts = $this->db->query("SELECT COUNT(*) as count FROM contracts WHERE status = 'active'")->fetch()['count'];

            echo "\n📈 Statistiques supplémentaires:\n";
            echo "  • Employés actifs: $activeEmployees\n";
            echo "  • Contrats actifs: $activeContracts\n";

            echo "\n";
        } catch (\Exception $e) {
            echo "❌ Erreur: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Truncate test data
     */
    private function truncateData()
    {
        echo "\n⚠️  ATTENTION: Cette action supprimera TOUTES les données de test!\n";
        echo "Êtes-vous certain? (oui/non): ";
        $confirm = trim(fgets(STDIN));

        if (strtolower($confirm) !== 'oui') {
            echo "Opération annulée.\n";
            return;
        }

        try {
            $this->db->getConnection()->exec("TRUNCATE TABLE contracts");
            $this->db->getConnection()->exec("TRUNCATE TABLE employees");
            $this->db->getConnection()->exec("TRUNCATE TABLE users");

            echo "✅ Toutes les données de test ont été supprimées.\n";
        } catch (\Exception $e) {
            echo "❌ Erreur: " . $e->getMessage() . "\n";
        }
    }
}

// Run menu
if (php_sapi_name() === 'cli') {
    $menu = new SeederMenu();
    $menu->showMenu();
} else {
    die("This script can only be run from command line.\n");
}
