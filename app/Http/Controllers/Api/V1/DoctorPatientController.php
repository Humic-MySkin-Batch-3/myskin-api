<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Models\Account;
use App\Http\Resources\V1\PatientListResource;
use Illuminate\Http\Request;

class DoctorPatientController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = $request->user()->id;
        $limit    = (int) $request->query('limit', 0);

        $query = Account::where('role', 'patient')
            ->whereHas('submission', fn($q) => $q->where('doctor_id', $doctorId))
            ->withCount(['submission as submission_count' => fn($q) => $q->where('doctor_id', $doctorId)])
            ->orderBy('name');

        if ($limit > 0) {
            $patients = $query->limit($limit)->get(['id','name','phone']);
        } else {
            $patients = $query->get(['id','name','phone']);
        }

        return PatientListResource::collection($patients);
    }

}
