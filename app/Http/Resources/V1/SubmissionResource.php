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
        return [
            'id' => $this->id,
            'patientId' => $this->patient_id,
            'doctorId' => $this->doctor_id,
            'imageUrl'     => Storage::disk('public')->url($this->image_path),
            'complaint' => $this->complaint,
            'status' => $this->status,
            'diagnosis' => $this->diagnosis,
            'doctorNote' => $this->doctor_note,
            'submittedAt' => $this->submitted_at,
            'verifiedAt' => $this->verified_at,
        ];
    }
}
