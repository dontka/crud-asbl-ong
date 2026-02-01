<?php

/**
 * Security Logging System
 * Phase 6.2: Security Enhancement
 */

class SecurityLog
{
    private static $logFile = "logs/security.log";

    /**
     * Log security event
     * @param string $event
     * @param array $data
     */
    public static function log($event, $data = [])
    {
        $timestamp = date("Y-m-d H:i:s");
        $ip = $_SERVER["REMOTE_ADDR"] ?? "unknown";
        $userAgent = $_SERVER["HTTP_USER_AGENT"] ?? "unknown";
        $userId = $_SESSION["user_id"] ?? "guest";

        $logEntry = sprintf(
            "[%s] %s | IP: %s | User: %s | Event: %s | Data: %s | UA: %s\n",
            $timestamp,
            strtoupper($event),
            $ip,
            $userId,
            $event,
            json_encode($data),
            substr($userAgent, 0, 100)
        );

        // Ensure log directory exists
        $logDir = dirname(self::$logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        file_put_contents(self::$logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log failed login attempt
     * @param string $username
     */
    public static function logFailedLogin($username)
    {
        self::log("FAILED_LOGIN", ["username" => $username]);
    }

    /**
     * Log successful login
     * @param int $userId
     * @param string $username
     */
    public static function logSuccessfulLogin($userId, $username)
    {
        self::log("SUCCESSFUL_LOGIN", ["user_id" => $userId, "username" => $username]);
    }

    /**
     * Log suspicious activity
     * @param string $activity
     * @param array $details
     */
    public static function logSuspiciousActivity($activity, $details = [])
    {
        self::log("SUSPICIOUS_ACTIVITY", array_merge(["activity" => $activity], $details));
    }

    /**
     * Log CSRF attempt
     */
    public static function logCSRFAttempt()
    {
        self::log("CSRF_ATTEMPT", ["url" => $_SERVER["REQUEST_URI"]]);
    }

    /**
     * Get recent security logs
     * @param int $limit
     * @return array
     */
    public static function getRecentLogs($limit = 100)
    {
        if (!file_exists(self::$logFile)) {
            return [];
        }

        $logs = file(self::$logFile);
        $logs = array_reverse($logs); // Most recent first
        return array_slice($logs, 0, $limit);
    }
}
?>