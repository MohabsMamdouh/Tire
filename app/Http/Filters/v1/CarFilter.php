<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CustomersFilter extends ApiFilter
{
    protected $safeParms = [
        'carName' => ['eq'],
    ];

    protected $columnMap = [
        'carName' => 'car_name',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];


    protected $opreatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'ne' => '!=',
    ];
}