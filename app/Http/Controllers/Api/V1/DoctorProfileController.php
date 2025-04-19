<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\DoctorProfileFilter;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\StoreDoctorProfileRequest;
use App\Http\Requests\V1\UpdateDoctorProfileRequest;
use App\Http\Resources\V1\DoctorProfileCollection;
use App\Http\Resources\V1\DoctorProfileResource;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(DoctorProfile::class,'doctorProfile');
    }
    public function index(Request $r)
    {
        $this->authorize('viewAny', DoctorProfile::class);

        // kalau dokter, return hanya profil dia sendiri:
        if ($r->user()->role==='doctor') {
            $p = DoctorProfile::where('user_id',$r->user()->id)->firstOrFail();
            return new DoctorProfileCollection(collect([$p]));
        }

        // kalau admin, bisa lihat semua:
        return new DoctorProfileCollection(DoctorProfile::paginate());
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
