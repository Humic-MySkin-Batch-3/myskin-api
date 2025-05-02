<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PatientDetectionDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'doctorId'      => $this->doctor_id,
            'imageUrl'     => Storage::disk('public')->url($this->image_path),
            'diagnosis'    => $this->diagnosis ?? 'Belum dapat dipastikan',
            'diagnosisAi'  => $this->getDiagnosisAi(),
            'isSubmitted'  => $this->is_submitted,
            'status'       => $this->status,
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
