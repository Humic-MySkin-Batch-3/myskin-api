<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\SubmissionFilter;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\StoreSubmissionRequest;
use App\Http\Requests\V1\UpdateSubmissionRequest;
use App\Http\Resources\V1\PatientDetectionDetailResource;
use App\Http\Resources\V1\PatientDetectionHistoryResource;
use App\Http\Resources\V1\PatientSubmissionDetailResource;
use App\Http\Resources\V1\PatientSubmissionHistoryResource;
use App\Http\Resources\V1\SubmissionCollection;
use App\Http\Resources\V1\SubmissionResource;
use App\Models\Submission;
use App\Services\SkinAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Submission::class,'submission');
    }

    public function pending(Request $request)
    {
        $this->authorize('viewAny', Submission::class);

        $query = Submission::with('patient')
            ->where('status', 'pending');

        $subs = $query->paginate()
            ->appends($request->query());

        return new SubmissionCollection($subs);
    }

    public function history(Request $request)
    {
        $this->authorize('viewAny', Submission::class);

        $query = Submission::with('patient')
            ->where('status', '!=', 'pending');

        $subs = $query->paginate()
            ->appends($request->query());

        return new SubmissionCollection($subs);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Submission::class);

        $filter = new SubmissionFilter();
        $filterItems = $filter->transform($request);

        $query = Submission::where($filterItems);

        if ($request->user()->role === 'patient') {
            $query->where('patient_id', $request->user()->id);
        }

        $statusCounts = (clone $query)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $subs = $query
            ->paginate()
            ->appends($request->query());

        return (new SubmissionCollection($subs))
            ->additional(['statusCounts' => $statusCounts]);
    }

    public function detectionHistory(Request $r)
    {
        $user = $r->user();
        $subs  = Submission::where('patient_id',$user->id)
            ->orderBy('submitted_at','desc')->get();

        return PatientDetectionHistoryResource::collection($subs);
    }

    public function submissionHistory(Request $r)
    {
        $user = $r->user();
        $subs  = Submission::where('patient_id',$user->id)
            ->where('status','!=','pending')
            ->orderBy('verified_at','desc')->get();

        return PatientSubmissionHistoryResource::collection($subs);
    }

    public function detectionDetail($id)
    {
        $submission = Submission::findOrFail($id);

        $this->authorize('view', $submission);

        return new PatientDetectionDetailResource($submission);
    }

    public function submissionDetail($id)
    {
        $submission = Submission::findOrFail($id);

        $this->authorize('view', $submission);

        return new PatientSubmissionDetailResource($submission);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubmissionRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('image')->store('submissions', 'public');
        $data['image_path'] = $path;

        $data['submitted_at'] = Carbon::now();

        $percentage = SkinAiService::predict($request->file('image'));
        $data['percentage'] = $percentage;

        $submission = Submission::create($data);

        return (new SubmissionResource($submission))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
        return new SubmissionResource($submission);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        $data = $request->validated();

        if ($request->has('doctorId')) {
            $data['doctor_id'] = $request->input('doctorId');
        }

        // kalau pasien/sudah submit, set is_submitted
        if (in_array($request->user()->role, ['patient','admin'])) {
            $data['is_submitted'] = 'Sudah';
        }

        // untuk dokter/admin saat verifikasi
        if (in_array($request->user()->role, ['doctor','admin'])
            && isset($data['status'])
            && $data['status'] === 'verified'
            && ! $submission->verified_at
        ) {
            $data['verified_at'] = now();
        }

        $submission->update($data);

        return new SubmissionResource($submission->refresh());
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        //
        $submission->delete();
        return response()->json(['message' => 'Submission deleted successfully']);
    }
}
