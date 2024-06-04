<?php

namespace MVC\Modules;

use MVC\Modules\JWT;

class Authorization {
    public static function decodeJWT() {
        $header = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);

        if ($header[0] !== 'Bearer' || !$header[1]) {
            return false;
        }

        return JWT::verifyJWT($header[1]);
    }

    public static function isAdmin() {
        $payload = self::decodeJWT();

        if (!$payload || $payload['role'] !== 'admin') {
            return false;
        }

        return true;
    }
}