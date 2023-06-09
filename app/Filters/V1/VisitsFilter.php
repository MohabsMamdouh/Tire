<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class VisitsFilter extends ApiFilter
{
    protected $safeParms = [
        'customerId' => ['eq'],
        'userId' => ['eq'],
        'carModelId' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt', 'lte', 'gte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'lte', 'gte'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'userId' => 'user_id',
        'carModelId' => 'car_model_id',
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
        'lk' => 'like',
    ];
}
