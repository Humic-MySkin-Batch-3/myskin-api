<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $threshold     = config('ai.threshold');
        $labelPos      = config('ai.label_positive');
        $labelNeg      = config('ai.label_negative');

        $pct = $this->percentage;
        $diagnosisAi = is_numeric($pct)
            ? ($pct >= $threshold ? $labelPos : $labelNeg)
            : null;

        return [
            'id' => $this->id,
            'patientId' => $this->patient_id,
            'patientName' =>$this->patient->name,
            'doctorId' => $this->doctor_id,
            'imageUrl'     => Storage::disk('public')->url($this->image_path),
            'complaint' => $this->complaint,
            'status' => $this->status,
            'diagnosis' => $this->diagnosis ?? 'Belum dapat dipastikan',
            'doctorNote' => $this->doctor_note,
            'isSubmitted' => $this->is_submitted,
            'submittedAt'  => optional($this->submitted_at)->format('Y-m-d'),
            'verifiedAt'   => optional($this->verified_at)->format('Y-m-d'),
            'percentage'   => $this->percentage,
            'diagnosisAi' => $diagnosisAi,
        ];

    }
}
