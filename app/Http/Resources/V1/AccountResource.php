<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'dob' => $this->dob,
            'role' => $this->role,
            'doctorProfile' => DoctorProfileResource::make($this->whenLoaded('doctorProfile')),
            'submission' => SubmissionResource::collection($this->whenLoaded('submission')),
        ];
    }
}
