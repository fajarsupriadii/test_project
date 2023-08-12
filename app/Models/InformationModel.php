<?php

namespace App\Models;

use CodeIgniter\Model;

class InformationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'informations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code', 'name', 'view_name', 'field',
        'filter', 'custom_field', 'custom_filter', 'primary_field',
        'button', 'created_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'code'  => [
            'label'  => 'Code',
            'rules'  => 'required|max_length[75]',
        ],
        'name'  => [
            'label'  => 'Name',
            'rules'  => 'required|max_length[100]'
        ],
        'view_name' => [
            'label'  => 'Table / View Name',
            'rules'  => 'required|max_length[255]'
        ],
        'field' => [
            'label'  => 'Field',
            'rules'  => 'required'
        ],
        'primary_field' => [
            'label'  => 'Primary Field',
            'rules'  => 'required|max_length[50]'
        ],
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
