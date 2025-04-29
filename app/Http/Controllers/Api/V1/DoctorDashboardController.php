<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\V1\SubmissionListResource;
use App\Models\Submission;
use App\Models\Account;
use App\Http\Resources\V1\DashboardStatsResource;

class DoctorDashboardController extends Controller
{
    public function stats()
    {
        $totalPatients    = Account::where('role','patient')->count();
        $pendingCount     = Submission::where('status','pending')->count();
        $verifiedCount    = Submission::where('status','verified')->count();

        return new DashboardStatsResource(compact(
            'totalPatients','pendingCount','verifiedCount'
        ));
    }

    public function pendingVerifications()
    {
        $subs = Submission::pending()
            ->with('patient:id,name')
            ->orderBy('submitted_at','desc')
            ->limit(10)
            ->get();

        return SubmissionListResource::collection($subs);
    }
}
