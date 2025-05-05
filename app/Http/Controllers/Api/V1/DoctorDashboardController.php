<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\V1\SubmissionListResource;
use App\Models\Submission;
use App\Models\Account;
use App\Http\Resources\V1\DashboardStatsResource;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    public function stats(Request $request)
    {
        $user = $request->user();

        $totalPatients = Submission::where('doctor_id', $user->id)
            ->distinct('patient_id')
            ->count('patient_id');

        $pendingCount = Submission::where('doctor_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $verifiedCount = Submission::where('doctor_id', $user->id)
            ->where('status', 'verified')
            ->count();

        return new DashboardStatsResource(compact(
            'totalPatients', 'pendingCount', 'verifiedCount'
        ));
    }


    public function pendingVerifications(Request $request)
    {
        $user  = $request->user();
        $limit = (int) $request->query('limit', 0);

        $query = Submission::pending()
            ->where('doctor_id', $user->id)
            ->with('patient:id,name')
            ->orderBy('submitted_at', 'desc');

        if ($limit > 0) {
            $subs = $query->limit($limit)->get();
        } else {
            $subs = $query->get();
        }

        return SubmissionListResource::collection($subs);
    }
}
