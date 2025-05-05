<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubmissionDetailResource extends JsonResource
{
    public function toArray(Request $request)
    {

        return [
            'id'           => $this->id,
            'doctorId'      => $this->doctor_id,
            'patientId'     => $this->patient->id,
            'patientName'  => $this->patient->name,
            'patientPhone' => $this->patient->phone,
            'patientEmail' => $this->patient->email,
            'patientDob'   => $this->patient->dob,
            'imageUrl'      => Storage::disk('public')->url($this->image_path),
            'complaint'    => $this->complaint,
            'status'       => $this->status,
            'percentage'   => $this->percentage,
            'diagnosis'    => $this->diagnosis ?? 'Belum dapat dipastikan',
            'diagnosisAi'  => $this->getDiagnosisAi(),
            'doctorNote'   => $this->doctor_note,
            'isSubmitted' => $this->is_submitted,
            'submittedAt'  => optional($this->submitted_at)->format('Y-m-d'),
            'verifiedAt'   => optional($this->verified_at)->format('Y-m-d'),
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
