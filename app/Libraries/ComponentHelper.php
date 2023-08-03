<?php

namespace App\Libraries;

class ComponentHelper 
{
    public static function formatCurrency($var)
    {
        $var = str_replace('.', ',', $var);
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1.$2', $var);
            if ($replaced != $var) {
                $var = $replaced;
            } else {
                break;
            }
        }
        return $var;
    }

    public static function formatNumber($var)
    {
        $explodedString = explode(',', $var);
        $result = str_replace(".", "", $explodedString[0]);

        if (isset($explodedString[1])) {
            $result = $result . '.' . $explodedString[1];
        }

        return $result;
    }

    public static function dataTableQuery($model, $request, $advancedFilter = [])
    {
        $countFiltered = null;
        $offset = $request->getVar('start');
        $limit = $request->getVar('length');
        $columnOrder = $request->getVar('order')[0]['column'];
        $orderBy = $request->getVar('columns')[$columnOrder]['data'];
        $orderType = $request->getVar('order')[0]['dir'];
        if (empty($advancedFilter)) {
            $advancedFilter = $request->getVar('advanced-filter');
        }

        if ($advancedFilter) {
            foreach ($advancedFilter as $key => $value) {
                if ($value) {
                    $model->like($key, $value, 'both', null, true);
                }
            }
            $countFiltered = $model->countAllResults(false);
        }

        $data = $model->orderBy($orderBy, $orderType)
            ->asArray()
            ->findAll($limit, $offset);

        return [
            'data' => $data,
            'countFiltered' => $countFiltered,
        ];
    }

}