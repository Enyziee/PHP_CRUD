<?php 

namespace MVC\Modules;

class JWT {
    private static $secret = "shiu! is secret";

    public static function createJWT($userid) {
        $header = base64_encode(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT'
        ]));
    
        $payload = base64_encode(json_encode([
            'userid' => $userid,
            'iat' => time(),
            'exp' => time() + 900
        ]));

        $payload = str_replace(['+', '/', '='], ['-', '_', ''], $payload);
    
        $signature = hash_hmac('sha256', ($header . $payload), JWT::$secret);
        
        return ($header . '.' . $payload . '.' . $signature);
    }

    public static function verifyJWT($token) {
        if (
            preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/",
                $token,
                $matches
            ) !== 1
        ) {
            throw new \Exception('Invalid token format');
        }

        $signature = hash_hmac('sha256', ($matches['header'] . $matches['payload']), JWT::$secret);

        $signatureFromToken = $matches['signature'];

        if (!hash_equals($signature, $signatureFromToken)) {
            throw new \Exception('Invalid token signature');
        }

        return base64_decode($matches['payload']);
    }
}
