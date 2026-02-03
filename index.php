<?php

/**
 * Main Entry Point for CRUD ASBL-ONG System
 * Handles routing and page display
 */

// Redirige vers l'installation si le site n'est pas encore installé
$lockFile = __DIR__ . '/installed.lock';
if (!file_exists($lockFile)) {
    header('Location: install.php');
    exit;
}

// Include configuration and autoloader
require_once 'config.php';
require_once 'autoloader.php';
require_once 'includes/security_headers.php';
require_once __DIR__ . '/core/router.php';
