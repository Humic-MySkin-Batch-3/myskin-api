<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DoctorDashboardController;
use App\Http\Controllers\Api\V1\DoctorPatientController;
use App\Http\Controllers\Api\V1\DoctorProfileController;
use App\Http\Controllers\Api\V1\DoctorSubmissionController;
use App\Http\Controllers\Api\V1\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function(){
    //Route::post('register', [AuthController::class,'register']);
    Route::post('register/patient', [AuthController::class, 'register']);
    Route::post('register/doctor',  [AuthController::class, 'registerDoctor']);
    Route::post('login',    [AuthController::class,'login']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function(){
    Route::get('user', function(Request $req){
        return $req->user();
    });

    Route::get('welcome', [AccountController::class, 'welcome']);
    Route::get('submissions/pending', [SubmissionController::class, 'pending']);
    Route::get('submissions/history', [SubmissionController::class, 'history']);

    // pasien
    Route::get('patient/detections',   [SubmissionController::class,'detectionHistory']);
    Route::post('patient/detections',  [SubmissionController::class,'store']);
    Route::get('patient/submissions',  [SubmissionController::class,'submissionHistory']);
    Route::get('patient/detection/{id}',   [SubmissionController::class,'detectionDetail']);
    Route::get('patient/submission/{id}',  [SubmissionController::class,'submissionDetail']);
    Route::patch('patient/submission/{submission}',  [SubmissionController::class,'update']);
    Route::delete('patient/submission/{submission}', [SubmissionController::class,'destroy']);
    Route::get('patient/doctors', [AccountController::class, 'listDoctors']);

    // resources
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('submissions', SubmissionController::class);
    //Route::post('submissions/bulk', [SubmissionController::class,'bulkStore']);
    Route::apiResource('doctorProfiles', DoctorProfileController::class);

    // logout
    Route::post('auth/logout', [AuthController::class,'logout']);
});

Route::middleware(['auth:sanctum','can:access-doctor-section'])
    ->prefix('v1/doctor')
    ->group(function(){
        Route::get('dashboard/stats',    [DoctorDashboardController::class,'stats']);
        Route::get('dashboard/pending',  [DoctorDashboardController::class,'pendingVerifications']);
        Route::get('patients',           [DoctorPatientController::class,'index']);
        Route::get('submissions/pending',[DoctorSubmissionController::class,'pending']);
        Route::get('submissions/history',[DoctorSubmissionController::class,'history']);
        Route::get('submissions/{id}/detail',[DoctorSubmissionController::class,'detail']);
        Route::patch('submissions/{submission}',[DoctorSubmissionController::class,'update']);
});


