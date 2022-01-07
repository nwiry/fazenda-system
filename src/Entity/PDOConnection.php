<?php

namespace App\Entity;

class PDOConnection
{
    public static function sqlite()
    {
        return new \PDO($_ENV['DATABASE_URL']);
    }
}