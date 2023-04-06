<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class FeedbacksFilter extends ApiFilter
{
    protected $safeParms = [
        'customerId' => ['eq'],
        'visitId' => ['eq'],
        'status' => ['eq'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'visitId' => 'visit_id',
    ];


    protected $opreatorMap = [
        'eq' => '=',
    ];
}
