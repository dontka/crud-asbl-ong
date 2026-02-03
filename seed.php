#!/usr/bin/env php
<?php

/**
 * Script CLI pour générer les données fictives
 * Utilisation: php seed.php [options]
 * 
 * Options:
 *   seed      - Génère les données fictives
 *   --help    - Affiche cette aide
 */

// Détecter le répertoire racine du projet
$rootDir = dirname(__FILE__);

// Charger la configuration
require_once $rootDir . '/config.php';
require_once $rootDir . '/models/Database.php';

// Autoloader
require_once $rootDir . '/vendor/autoload.php';

// Parser les arguments
$command = $argv[1] ?? 'help';

switch ($command) {
    case 'seed':
        runSeeder();
        break;
    case 'help':
    case '--help':
    case '-h':
        showHelp();
        break;
    default:
        echo "❌ Commande inconnue: $command\n";
        echo "Utilisez: php seed.php --help\n";
        exit(1);
}

/**
 * Exécute le seeder
 */
function runSeeder()
{
    try {
        echo "\n🌱 Démarrage du seeding des données fictives...\n\n";

        require_once __DIR__ . '/database/seeds/FakerSeeder.php';

        $seeder = new FakerSeeder();
        $seeder->seed();

        echo "\n✅ Seeding terminé avec succès !\n\n";
        exit(0);
    } catch (Exception $e) {
        echo "\n❌ Erreur lors du seeding:\n";
        echo "   " . $e->getMessage() . "\n\n";
        exit(1);
    }
}

/**
 * Affiche l'aide
 */
function showHelp()
{
    echo <<<'HELP'

╔════════════════════════════════════════════════════════════════╗
║  Générateur de Données Fictives - CRUD ASBL-ONG              ║
║  Utilise la bibliothèque Faker pour créer des données de test ║
╚════════════════════════════════════════════════════════════════╝

USAGE:
  php seed.php <commande> [options]

COMMANDES:
  seed              Génère les données fictives
  help, --help, -h  Affiche cette aide

EXAMPLES:
  php seed.php seed              # Génère toutes les données fictives
  php seed.php --help            # Affiche cette aide

DONNÉES GÉNÉRÉES:
  • 15 Utilisateurs fictifs (admin, manager, employee, member)
  • 25 Employés fictifs (positions, salaires, dates d'embauche)
  • 30 Contrats fictifs (CDI, CDD, Stage, etc.)
  • 40 Absences fictives (congés, maladie, formation)
  • 50 Membres fictifs (donateurs, bénévoles, partenaires)
  • 12 Projets fictifs (budgets, statuts, progression)
  • 15 Événements fictifs (conférences, workshops, meetings)
  • 60 Donations fictives (statuts, montants, devises)

  Total: 227+ enregistrements fictifs

AVERTISSEMENTS:
  ⚠️  Cette fonctionnalité est destinée au DÉVELOPPEMENT uniquement
  ⚠️  N'utilisez pas en production
  ⚠️  Les données générées peuvent être supprimées à tout moment
  ⚠️  Assurez-vous d'avoir une sauvegarde avant d'exécuter

REQUIREMENTS:
  • PHP 7.4+
  • Composer installé et à jour
  • fakerphp/faker installé (composer require fakerphp/faker)
  • Base de données MySQL/MariaDB disponible

HELP;

    exit(0);
}

HELP;
