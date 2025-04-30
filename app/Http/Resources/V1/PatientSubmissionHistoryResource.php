<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PatientSubmissionHistoryResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'submittedAt'   => optional($this->submitted_at)->format('Y-m-d'),
            'diagnosisAi'   => $this->getDiagnosisAi(),
            'imageUrl'      => Storage::disk('public')->url($this->image_path),
            'complaint'     => $this->complaint,
            'status'        => $this->status,
            'verifiedAt'    => optional($this->verified_at)->format('Y-m-d'),
            'verifiedBy'    => $this->doctor?->name,
            'diagnosis'     => $this->diagnosis,
            'doctorNote'    => $this->doctor_note,
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
