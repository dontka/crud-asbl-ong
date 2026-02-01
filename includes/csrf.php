<?php

/**
 * CSRF Protection Functions
 * Phase 6.2: Security Enhancement
 */

class CSRF
{
    private static $tokenName = "csrf_token";

    /**
     * Generate a new CSRF token
     * @return string
     */
    public static function generateToken()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION[self::$tokenName] = $token;
        return $token;
    }

    /**
     * Get current CSRF token
     * @return string|null
     */
    public static function getToken()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION[self::$tokenName] ?? null;
    }

    /**
     * Validate CSRF token
     * @param string $token
     * @return bool
     */
    public static function validateToken($token)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[self::$tokenName])) {
            return false;
        }

        $valid = hash_equals($_SESSION[self::$tokenName], $token);

        // Token is single-use
        unset($_SESSION[self::$tokenName]);

        return $valid;
    }

    /**
     * Get hidden input field for forms
     * @return string
     */
    public static function getTokenField()
    {
        $token = self::generateToken();
        return '<input type="hidden" name="' . self::$tokenName . '" value="' . htmlspecialchars($token) . '">';
    }
}
?>