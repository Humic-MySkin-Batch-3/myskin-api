<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Models\Submission;
use App\Http\Resources\V1\SubmissionListResource;
use App\Http\Resources\V1\SubmissionDetailResource;

class DoctorSubmissionController extends Controller
{
    public function pending()
    {
        return SubmissionListResource::collection(
            Submission::pending()
                ->with('patient:id,name')
                ->paginate()
        );
    }

    public function history()
    {
        return SubmissionListResource::collection(
            Submission::history()
                ->with('patient:id,name')
                ->paginate()
        );
    }

    public function detail($id)
    {
        $sub = Submission::with('patient')
            ->findOrFail($id);

        return new SubmissionDetailResource($sub);
    }
}
