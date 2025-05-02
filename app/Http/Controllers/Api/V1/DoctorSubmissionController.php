<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\DoctorUpdateSubmissionRequest;
use App\Http\Resources\V1\DoctorHistorySubmissionResource;
use App\Http\Resources\V1\SubmissionResource;
use App\Models\Submission;
use App\Http\Resources\V1\SubmissionListResource;
use App\Http\Resources\V1\SubmissionDetailResource;
use Illuminate\Http\Request;

class DoctorSubmissionController extends Controller
{
    public function update(DoctorUpdateSubmissionRequest $request, Submission $submission)
    {
        $this->authorize('update', $submission);

        $valid = $request->validated();

        $data = [
            'diagnosis'   => $valid['diagnosis'],
            'doctor_note' => $valid['doctorNote'],
            'doctor_id'   => $request->user()->id,
            'status'      => 'verified',
            'verified_at' => now(),
        ];


        $submission->update($data);

        return new SubmissionDetailResource(
            $submission->fresh()->load('patient')
        );
    }


    public function pending(Request $request)
    {
        $user = $request->user();

        $request->merge(['only_percentage' => true]);

        $subs = Submission::pending()
            ->where('doctor_id', $user->id)
            ->with('patient:id,name')
            ->orderBy('submitted_at','desc')
            ->get();

        return SubmissionListResource::collection($subs);
    }


    public function history(Request $request)
    {
        $this->authorize('viewAny', Submission::class);

        $doctorId = $request->user()->id;
        $limit    = (int) $request->query('limit', 0);

        $query = Submission::where('status', 'verified')
        ->where('doctor_id', $doctorId)
        ->with('patient:id,name')
            ->orderBy('verified_at', 'desc');

        if ($limit > 0) {
            $subs = $query->limit($limit)->get();
        } else {
            $subs = $query->get();
        }

        return DoctorHistorySubmissionResource::collection($subs);
    }


    public function detail($id)
    {
        $sub = Submission::with('patient')
            ->findOrFail($id);

        return new SubmissionDetailResource($sub);
    }
}
