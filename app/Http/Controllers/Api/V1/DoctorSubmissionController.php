<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\V1\DoctorHistorySubmissionResource;
use App\Models\Submission;
use App\Http\Resources\V1\SubmissionListResource;
use App\Http\Resources\V1\SubmissionDetailResource;
use Illuminate\Http\Request;

class DoctorSubmissionController extends Controller
{
    public function pending(Request $request)
    {
        $request->merge(['only_percentage' => true]);
        return SubmissionListResource::collection(
            Submission::pending()
                ->with('patient:id,name')
                ->paginate()
        );
    }

    public function history(Request $request)
    {
        $this->authorize('viewAny', Submission::class);

        $subs = Submission::query()
            ->where('status', '!=', 'pending')
            ->with('patient:id,name')
            ->orderBy('submitted_at', 'desc')
            ->paginate()
            ->appends($request->query());

        return DoctorHistorySubmissionResource::collection($subs);
    }

    public function detail($id)
    {
        $sub = Submission::with('patient')
            ->findOrFail($id);

        return new SubmissionDetailResource($sub);
    }
}
