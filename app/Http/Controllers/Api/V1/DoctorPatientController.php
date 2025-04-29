<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Models\Account;
use App\Http\Resources\V1\PatientListResource;

class DoctorPatientController extends Controller
{
    public function index()
    {
        $patients = Account::where('role','patient')
            ->withCount('submission')
            ->get(['id','name','phone']);

        return PatientListResource::collection($patients);
    }
}
