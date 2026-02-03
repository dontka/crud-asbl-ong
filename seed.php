<?php

/**
 * Faker Seeder - Generates Realistic Test Data
 * 
 * Usage: php seed.php [--users] [--employees] [--contracts] [--all]
 * 
 * Examples:
 *   php seed.php --all              # Generate all fake data
 *   php seed.php --users            # Generate only fake users
 *   php seed.php --employees        # Generate only fake employees
 *   php seed.php --contracts        # Generate only fake contracts
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/config.php';

use Faker\Factory as Faker;

class DataSeeder
{
    protected $faker;
    protected $db;
    protected $options;

    public function __construct()
    {
        $this->faker = Faker::create('fr_FR');
        $this->db = Database::getInstance();
        $this->options = $this->parseArguments();
    }

    /**
     * Parse CLI arguments
     */
    private function parseArguments()
    {
        global $argv;
        $options = [
            'users' => false,
            'employees' => false,
            'contracts' => false,
            'absences' => false,
            'all' => false,
        ];

        for ($i = 1; $i < count($argv); $i++) {
            $arg = str_replace('--', '', $argv[$i]);
            if (isset($options[$arg])) {
                $options[$arg] = true;
            }
        }

        // If --all, enable all options
        if ($options['all']) {
            $options['users'] = true;
            $options['employees'] = true;
            $options['contracts'] = true;
            $options['absences'] = true;
        }

        return $options;
    }

    /**
     * Run seeding based on options
     */
    public function run()
    {
        echo "\n╔════════════════════════════════════════════╗\n";
        echo "║       Faker Data Seeder (v1.0)            ║\n";
        echo "╚════════════════════════════════════════════╝\n\n";

        try {
            if ($this->options['users']) {
                $this->seedUsers();
            }
            if ($this->options['employees']) {
                $this->seedEmployees();
            }
            if ($this->options['contracts']) {
                $this->seedContracts();
            }
            if ($this->options['absences']) {
                $this->seedAbsences();
            }

            if (!$this->options['users'] && !$this->options['employees'] && !$this->options['contracts'] && !$this->options['absences']) {
                echo "❌ No options specified. Use: php seed.php [--users] [--employees] [--contracts] [--absences] [--all]\n\n";
                return;
            }

            echo "\n✅ Seeding completed successfully!\n\n";
        } catch (\Exception $e) {
            echo "\n❌ Error: " . $e->getMessage() . "\n\n";
        }
    }

    /**
     * Generate fake users
     */
    private function seedUsers()
    {
        echo "🔄 Generating fake users...\n";

        $count = 15;
        $roles = ['admin', 'moderator', 'visitor'];

        try {
            for ($i = 0; $i < $count; $i++) {
                $firstName = $this->faker->firstName();
                $lastName = $this->faker->lastName();
                $username = strtolower(str_replace(' ', '.', $firstName . '.' . $lastName));
                $email = strtolower(str_replace(' ', '.', $firstName . '.' . $lastName . '@' . $this->faker->domainName()));

                $data = [
                    'username' => $username,
                    'password' => password_hash('password123', PASSWORD_BCRYPT),
                    'email' => $email,
                    'role' => $roles[array_rand($roles)],
                ];

                $stmt = $this->db->getConnection()->prepare(
                    "INSERT INTO users (username, password, email, role) 
                     VALUES (:username, :password, :email, :role)"
                );

                $stmt->execute($data);
            }

            echo "   ✓ Created $count fake users\n";
        } catch (\Exception $e) {
            echo "   ⚠ Warning: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Generate fake employees
     */
    private function seedEmployees()
    {
        echo "🔄 Generating fake employees...\n";

        $count = 20;

        try {
            for ($i = 0; $i < $count; $i++) {
                $firstName = $this->faker->firstName();
                $lastName = $this->faker->lastName();

                $data = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => strtolower($firstName . '.' . $lastName . '@' . $this->faker->domainName()),
                    'phone' => $this->faker->phoneNumber(),
                    'hire_date' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
                    'status' => $this->faker->randomElement(['active', 'inactive', 'archived']),
                    'address' => $this->faker->streetAddress(),
                ];

                $stmt = $this->db->getConnection()->prepare(
                    "INSERT INTO employes (first_name, last_name, email, phone, hire_date, status, address) 
                     VALUES (:first_name, :last_name, :email, :phone, :hire_date, :status, :address)"
                );

                $stmt->execute($data);
            }

            echo "   ✓ Created $count fake employees\n";
        } catch (\Exception $e) {
            echo "   ⚠ Warning: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Generate fake contracts
     */
    private function seedContracts()
    {
        echo "🔄 Generating fake contracts...\n";

        $count = 25;
        $contractTypes = ['CDI', 'CDD', 'Stage', 'Autre'];
        $statuses = ['actif', 'termine', 'suspendu'];

        try {
            // Get existing employees first
            $employees = $this->db->getConnection()->query("SELECT id FROM employes LIMIT 20")->fetchAll();

            if (empty($employees)) {
                echo "   ⚠ No employees found. Please seed employees first.\n";
                return;
            }

            for ($i = 0; $i < min($count, count($employees)); $i++) {
                $employeeId = $employees[$i]['id'];
                $startDate = $this->faker->dateTimeBetween('-5 years', 'now');
                $contractType = $contractTypes[array_rand($contractTypes)];

                // CDI typically have no end date
                $endDate = ($contractType === 'CDI') ? null : $this->faker->dateTimeBetween($startDate, '+5 years');

                $data = [
                    'employe_id' => $employeeId,
                    'type' => $contractType,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
                    'status' => $statuses[array_rand($statuses)],
                ];

                $stmt = $this->db->getConnection()->prepare(
                    "INSERT INTO contrats (employe_id, type, start_date, end_date, status) 
                     VALUES (:employe_id, :type, :start_date, :end_date, :status)"
                );

                $stmt->execute($data);
            }

            echo "   ✓ Created " . min($count, count($employees)) . " fake contracts\n";
        } catch (\Exception $e) {
            echo "   ⚠ Warning: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Seed absences for existing employees
     */
    private function seedAbsences()
    {
        echo "🔄 Generating fake absences...\n";

        $count = 30;
        $absenceTypes = ['conge', 'maladie', 'autre'];
        $statuses = ['demande', 'valide', 'refuse'];

        try {
            // Get existing employees
            $employees = $this->db->getConnection()->query("SELECT id FROM employes LIMIT 50")->fetchAll();

            if (empty($employees)) {
                echo "   ⚠ No employees found. Please seed employees first.\n";
                return;
            }

            for ($i = 0; $i < $count; $i++) {
                $employee = $employees[array_rand($employees)];
                $employeeId = $employee['id'];
                $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
                $endDate = $this->faker->dateTimeBetween($startDate, '+30 days');

                $data = [
                    'employe_id' => $employeeId,
                    'type' => $absenceTypes[array_rand($absenceTypes)],
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'status' => $statuses[array_rand($statuses)],
                ];

                $stmt = $this->db->getConnection()->prepare(
                    "INSERT INTO absences (employe_id, type, start_date, end_date, status) 
                     VALUES (:employe_id, :type, :start_date, :end_date, :status)"
                );

                $stmt->execute($data);
            }

            echo "   ✓ Created $count fake absences\n";
        } catch (\Exception $e) {
            echo "   ⚠ Warning: " . $e->getMessage() . "\n";
        }
    }
}

// Run seeder
if (php_sapi_name() === 'cli') {
    $seeder = new DataSeeder();
    $seeder->run();
} else {
    die("This script can only be run from command line.\n");
}
