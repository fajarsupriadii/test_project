<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ComponentHelper;
use App\Models\UserVModel;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $session = session();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $model = (new UserVModel)->where(['email' => $email])->first();

        if (empty($model)) {
            return $this->respond(['message' => 'Invalid email or password.'], 422);
        }
        if(!password_verify($password, $model['password'])) {
            return $this->respond(['message' => 'Invalid email or password.'], 422);
        }

        $menu = ComponentHelper::getMenu();
        $sesData = [
            'user_id' => $model['user_id'],
            'name' => $model['employee_name'],
            'employee_id' => $model['employee_id'],
            'menu' => $menu,
            'isLogin' => true,
        ];
        $session->set($sesData);

        return $this->respond(['message' => 'Login Succesful'], 200);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to('/auth/login');
    }
}
