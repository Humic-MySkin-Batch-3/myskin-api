<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\DoctorProfileController;
use App\Http\Controllers\Api\V1\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('submissions', SubmissionController::class);
    Route::apiResource('doctorProfiles', DoctorProfileController::class);

    Route::post('submissions/bulk', [SubmissionController::class, 'bulkStore']);
});
