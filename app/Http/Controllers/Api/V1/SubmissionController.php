<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\SubmissionFilter;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\StoreSubmissionRequest;
use App\Http\Requests\V1\UpdateSubmissionRequest;
use App\Http\Resources\V1\SubmissionCollection;
use App\Http\Resources\V1\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\Request;


class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Submission::class,'submission');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Submission::class);

        $query = Submission::query()
            ->when(
                $request->user()->role === 'patient',
                fn($q) => $q->where('patient_id', $request->user()->id)
            );

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

        $data['image_path'] = $request
            ->file('image')
            ->store('submissions', 'public');

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

        if ($request->hasFile('image')) {
            // hapus file lama kalau perlu...
            $data['image_path'] = $request->file('image')->store('submissions', 'public');
        }

        $submission->update($data);

        return new SubmissionResource($submission->fresh());
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
