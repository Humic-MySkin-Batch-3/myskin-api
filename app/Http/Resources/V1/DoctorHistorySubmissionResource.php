<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DoctorHistorySubmissionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patientId' => $this->patient->id,
            'submittedAt'  => optional($this->submitted_at)->format('Y-m-d'),
            'patientName'  => $this->patient->name,
            'diagnosisAi'  => $this->getDiagnosisAi(),
            'diagnosis'    => $this->diagnosis,
            'doctorNote'   => $this->doctor_note,
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
