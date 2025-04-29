<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionDetailResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'           => $this->id,
            'patientName'  => $this->patient->name,
            'patientPhone' => $this->patient->phone,
            'patientEmail' => $this->patient->email,
            'patientDob'   => $this->patient->dob,
            'complaint'    => $this->complaint,
            'status'       => $this->status,
            'percentage'   => $this->percentage,
            'diagnosis'    => $this->diagnosis,
            'doctorNote'   => $this->doctor_note,
            'submittedAt'  => $this->submitted_at,
            'verifiedAt'   => $this->verified_at,
        ];
    }
}
