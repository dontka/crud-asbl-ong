<?php
// Politiques de sécurité (exemple)
return [
    'password_policy' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_number' => true,
        'require_special' => true,
    ],
    'mfa' => true,
    'session_timeout' => 3600,
    'log_retention_days' => 365,
];
