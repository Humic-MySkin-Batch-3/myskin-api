<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientListResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'phone'         => $this->phone,
            'submissionCount' => $this->submission_count,
        ];
    }
}
