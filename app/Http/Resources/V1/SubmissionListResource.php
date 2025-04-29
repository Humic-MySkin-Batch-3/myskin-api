<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionListResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'           => $this->id,
            'patientName'  => $this->patient->name,
            'submittedAt'  => $this->submitted_at,
            'percentage'   => $this->percentage,
        ];
    }
}
