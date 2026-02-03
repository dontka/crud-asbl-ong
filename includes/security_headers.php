<?php

/**
 * Security Headers
 * Phase 6.2: Security Enhancement
 */

// Set security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data:;");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Prevent clickjacking
header("X-Frame-Options: SAMEORIGIN");

// Disable caching of sensitive pages
if (isset($_SESSION['user_id'])) {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
}

echo "<!-- Security headers applied -->";
