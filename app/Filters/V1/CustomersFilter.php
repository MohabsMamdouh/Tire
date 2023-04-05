<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CustomersFilter extends ApiFilter
{
    protected $safeParms = [
        'customerFname' => ['eq'],
        'customerAddress' => ['eq'],
        'email' => ['eq'],
        'customerUsername' => ['eq'],
        'customerPhone' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt', 'lte', 'gte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'lte', 'gte'],
    ];

    protected $columnMap = [
        'customerFname' => 'customer_fname',
        'customerAddress' => 'customer_address',
        'customerUsername' => 'customer_username',
        'customerPhone' => 'customer_phone',
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