<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\InformationModel;
use App\Libraries\JWTLib;
use CodeIgniter\API\ResponseTrait;

class Information extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //
    }

    public function store()
    {
        if(!$this->request->is('post')) {
            return $this->respond(['message' => 'Invalid method.'], 500);
        }

        $model = new InformationModel();
        $jwtPayload = (new JWTLib)->decodeToken($this->request->header('Authorization'));
        $data = [
            'code' => $this->request->getVar('code'),
            'name'  => $this->request->getVar('name'),
            'view_name'  => $this->request->getVar('view_name'),
            'field' => json_encode($this->request->getVar('field')),
            'filter'  => json_encode($this->request->getVar('filter')),
            'custom_field'  => json_encode($this->request->getVar('custom_field')),
            'primary_field' => $this->request->getVar('primary_field'),
            'button'  => json_encode($this->request->getVar('button')),
            'created_by'  => $jwtPayload->sub,
        ];

        if(!$model->save($data)) {
            return $this->respond([
                'message' => 'Process Failed.',
                'errors' => $model->errors()
            ], 422);
        }

        return $this->respond([
            'message' => 'Process Success',
            'id' => $model->getInsertID()
        ], 200);
    }
}
