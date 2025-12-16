<?php

if (!function_exists('formatTime')) {
    /**
     * Format seconds into a human-readable string.
     *
     * @param int $seconds
     * @return string
     */
    function formatTime($seconds) {
        $days = floor($seconds / (3600 * 24));
        $hours = floor(($seconds % (3600 * 24)) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        
        return "{$days}d {$hours}h {$minutes}m {$secs}s";
    }
}