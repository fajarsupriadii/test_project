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

    public static function dataTableQueryBuilder($model, $request, $advancedFilter = [], $information)
    {
        $results = [];
        $countFiltered = 0;
        $offset = $request->getVar('start');
        $limit = $request->getVar('length');
        $columnOrder = $request->getVar('order')[0]['column'];
        $orderBy = $request->getVar('columns')[$columnOrder]['data'];
        $orderType = $request->getVar('order')[0]['dir'];
        if (empty($advancedFilter)) {
            $advancedFilter = $request->getVar('advanced-filter');
        }

        $informationFilter = json_decode($information['filter']);
        foreach ($informationFilter as $value) {
            if (isset($value->type)) {
                if ($value->type->name == "dateRange") {
                    $start[$value->fieldName] = date('Y-m-d 00:00:00');
                    $end[$value->fieldName] = date('Y-m-d 23:59:59');

                    if (isset($advancedFilter[$value->fieldName])) {
                        $date = explode(' - ', $advancedFilter[$value->fieldName]);
                        $start[$value->fieldName] = date('Y-m-d H:i:s', strtotime($date[0] . ' 00:00:00'));
                        $end[$value->fieldName] = date('Y-m-d H:i:s', strtotime($date[1] . ' 23:59:59'));
                        unset($advancedFilter[$value->fieldName]);
                    }

                    $model->where("".$value->fieldName." BETWEEN '".$start[$value->fieldName]."' AND '".$end[$value->fieldName]."'");
                }
            }
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
            ->limit($limit, $offset)
            ->get()
            ->getResult('array');

        $customField = json_decode($information['custom_field']);
        foreach ($data as $key => $value) {
            $value['primary'] = $value[$information['primary_field']];
            foreach ($customField as $v) {
                switch ($v->type) {
                    case "date_format":
                        $value[$v->field] = date($v->format, strtotime($value[$v->target]));
                        break;
                    case "combine_value":
                        $combineResult = null;
                        foreach ($v->param as $valueCombine) {
                            $targetValue = $value[$valueCombine->target];
                            if (isset($valueCombine->helper)) {
                                switch ($valueCombine->helper) {
                                    case "format_currency":
                                        $targetValue = self::formatCurrency($value[$valueCombine->target]);
                                    default:
                                        break;
                                }
                            }
                            $combineResult .= $targetValue;
                            if (isset($valueCombine->separator)) {
                                $combineResult .= $valueCombine->separator;
                            }
                        }
                        $value[$v->field] = $combineResult;
                        break;
                    default:
                        break;
                }
            }
            $results[$key] = $value;
        }

        return [
            'data' => $results,
            'countFiltered' => $countFiltered,
        ];
    }

}