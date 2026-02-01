<?php
/**
 * Simple Autoloader
 * Based on Phase 3: Environment Setup and Base Structure - Step 3.3
 */

spl_autoload_register(function ($className) {
    // Define class paths
    $paths = [
        MODELS_PATH . $className . '.php',
        CONTROLLERS_PATH . $className . '.php',
        CONFIG_PATH . $className . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
?>