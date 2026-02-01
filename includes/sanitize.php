<?php

/**
 * Input Sanitization Helper
 * Phase 6.2: Security Enhancement
 */

class Sanitize
{
    /**
     * Sanitize string input
     * @param string $input
     * @return string
     */
    public static function string($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize email input
     * @param string $email
     * @return string
     */
    public static function email($email)
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize numeric input
     * @param mixed $number
     * @return float
     */
    public static function number($number)
    {
        return filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Sanitize SQL input (for prepared statements)
     * @param string $input
     * @return string
     */
    public static function sql($input)
    {
        // This is for display purposes only - actual SQL protection is via prepared statements
        return addslashes($input);
    }

    /**
     * Clean array recursively
     * @param array $array
     * @return array
     */
    public static function array($array)
    {
        $clean = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $clean[self::string($key)] = self::array($value);
            } else {
                $clean[self::string($key)] = self::string($value);
            }
        }
        return $clean;
    }

    /**
     * Validate and sanitize POST data
     * @return array
     */
    public static function post()
    {
        return self::array($_POST);
    }

    /**
     * Validate and sanitize GET data
     * @return array
     */
    public static function get()
    {
        return self::array($_GET);
    }
}
?>