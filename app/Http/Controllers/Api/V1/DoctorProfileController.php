<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\DoctorProfileFilter;
use App\Http\Requests\V1\StoreDoctorProfileRequest;
use App\Http\Requests\V1\UpdateDoctorProfileRequest;
use App\Http\Resources\V1\DoctorProfileCollection;
use App\Http\Resources\V1\DoctorProfileResource;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new DoctorProfileFilter();
        $queryItems = $filter->transform($request); // [column, operator, value]

        if (count($queryItems) == 0) {
            return new DoctorProfileCollection(DoctorProfile::paginate());
        } else {
            $doctorProfiles = DoctorProfile::where($queryItems)->paginate();
            return new DoctorProfileCollection($doctorProfiles->appends($request->query()));
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
    public function store(StoreDoctorProfileRequest $request)
    {
        //
        return new DoctorProfileResource(DoctorProfile::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(DoctorProfile $doctorProfile)
    {
        //
        return new DoctorProfileResource($doctorProfile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DoctorProfile $doctorProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorProfileRequest $request, DoctorProfile $doctorProfile)
    {
        //
        $doctorProfile->update($request->validated());
        return new DoctorProfileResource($doctorProfile->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DoctorProfile $doctorProfile)
    {
        //
        $doctorProfile->delete();
        return response()->json(['message' => 'Doctor profile deleted successfully'], 200);
    }
}
