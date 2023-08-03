<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderVModel;
use App\Libraries\ComponentHelper;
use CodeIgniter\API\ResponseTrait;

class Order extends BaseController
{
    use ResponseTrait;
    
    public function index()
    {
        return view('order/index');
    }

    public function getData()
    {
        $results = [];
        $draw = $this->request->getVar('draw');
        $advancedFilter = $this->request->getVar('advanced-filter');
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        $data = (new OrderVModel)->select([
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
        ]);
        $count = $data->countAllResults(false);

        /** Custom Filter */
        if (isset($advancedFilter['order_date'])) {
            $order_date = explode(' - ', $advancedFilter['order_date']);
            $start = date('Y-m-d H:i:s', strtotime($order_date[0] . ' 00:00:00'));
            $end = date('Y-m-d H:i:s', strtotime($order_date[1] . ' 23:59:59'));
            unset($advancedFilter['order_date']);
        }
        $data->where("order_date BETWEEN '$start' AND '$end'");

        if (isset($advancedFilter['amount'])) {
            $amount = explode(' ', $advancedFilter['amount']);
            if (isset($amount[1])) {
                $data->groupStart()
                    ->like('amount', ComponentHelper::formatNumber($amount[1]), 'both', null, true)
                    ->like('currency', $amount[0], 'both', null, true)
                    ->groupEnd();
            } else {
                $data->like('amount', ComponentHelper::formatNumber($amount[0]), 'both', null, true);
            }
            unset($advancedFilter['amount']);
        }
        /** End of Custom Fitler */

        $data = ComponentHelper::dataTableQuery($data, $this->request, $advancedFilter);
        foreach ($data['data'] as $key => $value) {
            $value['order_date'] = date('l, d F Y', strtotime($value['order_date']));
            $value['amount'] = $value['currency'] .' '. ComponentHelper::formatCurrency($value['amount']);
            $results[$key] = $value;
        }
        
        return $this->respond([
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => ($data['countFiltered']) ? $data['countFiltered'] : $count,
            'data' => $results,
        ], 200);
    }
}
