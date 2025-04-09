<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class AccountFilter extends ApiFilter {
    protected $safeParms = [
        'id' => ['eq'],
        'name' => ['eq'],
        'email' => ['eq'],
        'phone' => ['eq'],
        'dob' => ['eq'],
        'role' => ['eq'],
    ];

    protected $columnMap = [
    ];
    protected $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'lt' => '<',
        'lte' => '<=',
        'gte' => '>=',
        'gt' => '>',
    ];
}
