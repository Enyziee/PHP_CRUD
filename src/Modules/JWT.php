<?php 

namespace MVC\Modules;

use MVC\Models\Usuarios;

class JWT {
    private static $secret = "shiu! is secret";

    public static function createJWT(Usuarios $user): string {
        $header = base64_encode(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT'
        ]));
    
        $payload = base64_encode(json_encode([
            'userid' => $user->id,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + 1800
        ]));

        $payload = str_replace(['+', '/', '='], ['-', '_', ''], $payload);
    
        $signature = hash_hmac('sha256', ($header . $payload), JWT::$secret);
        
        return ($header . '.' . $payload . '.' . $signature);
    }

    public static function verifyJWT($token): ?array {
        if (
            preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/",
                $token,
                $matches
            ) !== 1
        ) {
            return null;
        }

        $signature = hash_hmac('sha256', ($matches['header'] . $matches['payload']), JWT::$secret);

        $signatureFromToken = $matches['signature'];

        if (!hash_equals($signature, $signatureFromToken)) {
            return null;
        }

        $payload = base64_decode($matches['payload']);
        $payloadDecoded = json_decode($payload, true);

        return $payloadDecoded;
    }
}
