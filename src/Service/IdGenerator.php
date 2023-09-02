<?php

namespace App\Service;

class IdGenerator
{
    public static function generateIdAsInteger(): int
    {
        $microtime = microtime(true); // Get current timestamp with microseconds
        $random = mt_rand(100000, 999999); // Generate a random number
        $stringToHash = $microtime . $random; // Combine timestamp and random number
        return crc32($stringToHash);
    }
}