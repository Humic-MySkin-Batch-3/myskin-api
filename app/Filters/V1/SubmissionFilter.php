<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
class SubmissionFilter extends ApiFilter
{
    protected $safeParms = [
        'patient_id' => ['eq'],
        'doctor_id' => ['eq'],
        'image_path' => ['eq'],
        'complaint' => ['eq'],
        'status' => ['eq', 'ne'],
        'diagnosis' => ['eq'],
        'doctor_note' => ['eq'],
        'submitted_at' => ['eq'],
        'verified_at' => ['eq'],
    ];

    protected $columnMap = [
        //'patient_id' => 'patient_id',
        //'doctor_id' => 'doctor_id',
        //'verified_at' => 'verified_at',
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
