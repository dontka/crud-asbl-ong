<?php

/**
 * Simple File-based Cache
 * Phase 6.3: Optimization
 */

class Cache
{
    private static $cacheDir = "cache/";
    private static $defaultTTL = 3600; // 1 hour

    /**
     * Get cached data
     * @param string $key
     * @return mixed|null
     */
    public static function get($key)
    {
        $file = self::$cacheDir . md5($key) . ".cache";

        if (!file_exists($file)) {
            return null;
        }

        $data = unserialize(file_get_contents($file));

        if ($data["expires"] < time()) {
            self::delete($key);
            return null;
        }

        return $data["value"];
    }

    /**
     * Set cached data
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     */
    public static function set($key, $value, $ttl = null)
    {
        if ($ttl === null) {
            $ttl = self::$defaultTTL;
        }

        $file = self::$cacheDir . md5($key) . ".cache";
        $data = [
            "value" => $value,
            "expires" => time() + $ttl
        ];

        file_put_contents($file, serialize($data));
    }

    /**
     * Delete cached data
     * @param string $key
     */
    public static function delete($key)
    {
        $file = self::$cacheDir . md5($key) . ".cache";
        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * Clear all cache
     */
    public static function clear()
    {
        $files = glob(self::$cacheDir . "*.cache");
        foreach ($files as $file) {
            unlink($file);
        }
    }

    /**
     * Get or set cache with callback
     * @param string $key
     * @param callable $callback
     * @param int $ttl
     * @return mixed
     */
    public static function remember($key, callable $callback, $ttl = null)
    {
        $cached = self::get($key);
        if ($cached !== null) {
            return $cached;
        }

        $value = $callback();
        self::set($key, $value, $ttl);
        return $value;
    }
}
?>