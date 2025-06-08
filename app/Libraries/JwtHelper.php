<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    private $secret;

    public function __construct()
    {
        $this->secret = getenv('JWT_SECRET') ?: 'secretKey123';
    }

    public function encode($data)
    {
        $payload = [
            'iss' => 'ci4-jwt',
            'iat' => time(),
            'exp' => time() + 3600, // Token berlaku 1 jam
            'data' => $data
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function decode($jwt)
    {
        return JWT::decode($jwt, new Key($this->secret, 'HS256'));
    }
}
