<?php

namespace App\Service;

class IdGenerator
{
    public static function generateIdAsInteger(): int
    {
        // Generate a random number
        return mt_rand(10000000, 99999999);
    }
}