<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\SubmissionFilter;
use App\Http\Requests\V1\StoreSubmissionRequest;
use App\Http\Requests\V1\UpdateSubmissionRequest;
use App\Http\Resources\V1\SubmissionCollection;
use App\Http\Resources\V1\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\Request;


class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new SubmissionFilter();
        $queryItems = $filter->transform($request); // [column, operator, value]

        if (count($queryItems) == 0) {
            return new SubmissionCollection(Submission::paginate());
        } else {
            $submissions = Submission::where($queryItems)->paginate();
            return new SubmissionCollection($submissions->appends($request->query()));
        }
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
        //
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
        //
        $submission->update($request->validated());
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
