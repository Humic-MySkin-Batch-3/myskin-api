<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubmissionListResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $onlyPercentage = $request->get('only_percentage', false);

        if ($onlyPercentage) {
            return [
                'id'          => $this->id,
                'patientName'  => $this->patient->name,
                'submittedAt'  => optional($this->submitted_at)->format('Y-m-d'),
                'imageUrl'      => Storage::disk('public')->url($this->image_path),
                'diagnosisAi' => $this->percentage,
            ];
        }

        // versi full list
        return [
            'id'           => $this->id,
            'patientName'  => $this->patient->name,
            'submittedAt'  => optional($this->submitted_at)->format('Y-m-d'),
            'diagnosisAi'  => $this->getDiagnosisAi(),
        ];
    }

    private function getDiagnosisAi(): ?string
    {
        $pct       = $this->percentage;
        $threshold = config('ai.threshold');
        $labelPos  = config('ai.label_positive');
        $labelNeg  = config('ai.label_negative');

        return is_numeric($pct)
            ? sprintf('%d%% %s', round($pct * 1), $pct >= $threshold ? $labelPos : $labelNeg)
            : null;
    }
}
