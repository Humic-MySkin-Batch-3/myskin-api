<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DoctorProfileController;
use App\Http\Controllers\Api\V1\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function(){
    Route::post('register', [AuthController::class,'register']);
    Route::post('login',    [AuthController::class,'login']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function(){
    Route::get('user', function(Request $req){
        return $req->user();
    });

    // resources
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('submissions', SubmissionController::class);
    //Route::post('submissions/bulk', [SubmissionController::class,'bulkStore']);
    Route::apiResource('doctorProfiles', DoctorProfileController::class);

    // logout
    Route::post('auth/logout', [AuthController::class,'logout']);
});
