<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PatientSubmissionDetailResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $this->patient;

        return [
            'imageUrl'      => Storage::disk('public')->url($this->image_path),
            'verifiedBy'    => $this->doctor?->name,
            'patient'       => [
                'name'  => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'dob'   => optional($user->dob)->format('Y-m-d'),
            ],
            'complaint'     => $this->complaint,
            'diagnosis'     => $this->diagnosis,
            'diagnosisAi'   => $this->getDiagnosisAi(),
            'status'        => $this->status,
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
