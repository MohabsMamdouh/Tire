<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class CustomersFilter extends ApiFilter
{
    protected $safeParms = [
        'fname' => ['eq'],
        'email' => ['eq'],
        'username' => ['eq'],
        'phone' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt', 'lte', 'gte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'lte', 'gte'],
    ];

    protected $columnMap = [
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