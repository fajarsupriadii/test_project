<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\OrderVModel;
use App\Libraries\JWTLib;
use CodeIgniter\API\ResponseTrait;

class Order extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $jwtPayload = (new JWTLib)->decodeToken($this->request->header('Authorization'));
        $employee_id = $jwtPayload->employee_id;

        $data = (new OrderVModel)->getDataByEmployeeId($employee_id);

        return $this->respond([
            'results' => $data
        ], 200);
    }
}
