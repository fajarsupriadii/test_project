<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderVModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'order_v';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;

    public function getDataByEmployeeId($employee_id) {
        $result = $this->select([
            'order_id',
            'employee_no',
            'employee_name',
            'employee_email',
            'employee_phone',
            'office',
            'order_date',
            'item',
            'currency',
            'amount',
            'client_no',
            'client_name',
            'client_email',
            'client_phone', 
        ])->where([
            'employee_id' => $employee_id
        ])->asArray()->findAll();

        return $result;
    }
}
