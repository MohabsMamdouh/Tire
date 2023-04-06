<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CarsFilter extends ApiFilter
{
    protected $safeParms = [
        'carName' => ['eq', 'lk'],
    ];

    protected $columnMap = [
        'carName' => 'car_name',
    ];


    protected $opreatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'ne' => '!=',
        'lk' => 'like',
    ];
}