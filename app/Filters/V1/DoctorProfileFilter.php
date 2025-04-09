<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
class DoctorProfileFilter extends ApiFilter
{
    protected $safeParms = [
        'user_id' => ['eq'],
        'specialization' => ['eq'],
        'license_number' => ['eq'],
        'license_file_path' => ['eq'],
        'diploma_file_path' => ['eq'],
        'certification' => ['eq'],
        'current_institution' => ['eq'],
        'years_of_experience' => ['eq', 'gte', 'lte', 'gt', 'lt'],
        'work_history' => ['eq'],
        'publications' => ['eq']
    ];

    protected $columnMap = [
        //'user_id' => 'user_id',
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
