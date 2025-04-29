<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'userId' =>$this->user_id,
            'specialization' =>$this->specialization,
            'licenseNumber' =>$this->license_number,
            'licenseFilePath' =>$this->license_file_path,
            'diplomaFilePath' =>$this->diploma_file_path,
            'certification' =>$this->certification,
            'currentInstitution' =>$this->current_institution,
            //'yearsOfExperience' =>$this->years_of_experience,
            'workHistory' =>$this->work_history,
            'publications' =>$this->publications
        ];
    }
}
