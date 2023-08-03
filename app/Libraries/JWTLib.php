<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTLib {

    public function generateToken($userData)
    {
        $token = null;
        if (!empty($userData)) {
            $key = getenv('JWT_SECRET');
            $payload = [
                "sub" => $userData['user_id'],
                "name" => $userData['employee_name'],
                "iat" => time(),
                "exp" => strtotime('+1 day'),
                "email" => $userData['email'],
                "employee_id" => $userData['employee_id']
            ];
            $token = JWT::encode($payload, $key, 'HS256');
        }

        return $token;
    }

    public function decodeToken($header)
    {
        $result = false;
        $key = getenv('JWT_SECRET');
        if(!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }

        try {
            $result = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            $result = false;
        }
        
        return $result;
    }
    
}