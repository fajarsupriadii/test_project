<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InformationModel;
use App\Libraries\ComponentHelper;
use CodeIgniter\API\ResponseTrait;

class Information extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $code = $this->request->getVar('code');
        $data = (new InformationModel)->select([
            'code',
            'name',
            'field',
            'button',
            'filter',
        ])->where([
            'code' => $code
        ])->asArray()->first();

        return view('information/index', ['data' => $data]);
    }

    public function getData()
    {
        $code = $this->request->getVar('code');
        $draw = $this->request->getVar('draw');
        $results = [];
        $recordsTotal = $recordsFiltered = 0;

        $information = (new InformationModel)->select([
            'view_name',
            'field',
            'filter',
            'custom_field',
            'primary_field',
            'custom_filter',
        ])->where([
            'code' => $code
        ])->asArray()->first();

        if (!empty($information)) {
            $advancedFilter = $this->request->getVar('advanced-filter');
            $db = \Config\Database::connect();
            $builder = $db->table($information['view_name']);
            $data = $builder->select('*');
            $recordsTotal = $data->countAllResults(false);

            $data = ComponentHelper::dataTableQueryBuilder($data, $this->request, $advancedFilter, $information);
            $results = $data['data'];
            $recordsFiltered = $data['countFiltered'];
        }
        
        return $this->respond([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $results,
        ], 200);
    }
}
