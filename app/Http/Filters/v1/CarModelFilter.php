<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CustomersFilter extends ApiFilter
{
    protected $safeParms = [
        'model' => ['eq'],
        'carId' => ['eq'],
        'fueltype' => ['eq'],
        'fueltype1' => ['eq'],
    ];

    protected $columnMap = [
        'carId' => 'car_id',
        'engDscr' => 'eng_dscr',
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
