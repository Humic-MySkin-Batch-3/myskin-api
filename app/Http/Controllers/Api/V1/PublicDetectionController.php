<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\PublicDetectionRequest;
use App\Services\SkinAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicDetectionController extends Controller
{
    public function detect(PublicDetectionRequest $request): JsonResponse
    {
        $image = $request->file('image');

        $pct = SkinAiService::predict($image);

        $threshold = config('ai.threshold');
        $labelPos  = config('ai.label_positive');
        $labelNeg  = config('ai.label_negative');
        $label     = is_numeric($pct)
            ? ($pct >= $threshold ? $labelPos : $labelNeg)
            : null;

        return response()->json([
            'percentage'  => $pct,
            'diagnosisAi' => $label,
        ]);
    }
}
