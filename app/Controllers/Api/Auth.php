<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserVModel;
use App\Libraries\JWTLib;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $model = (new UserVModel)->where(['email' => $email])->first();
        
        if (empty($model)) {
            return $this->respond(['message' => 'Invalid email or password.'], 422);
        }
        if(!password_verify($password, $model['password'])) {
            return $this->respond(['message' => 'Invalid email or password.'], 422);
        }

        // Generate token
        $token = (new JWTLib)->generateToken($model);
          
        return $this->respond([
            'message' => 'Login Succesful',
            'token' => $token
        ], 200);
    }
}
