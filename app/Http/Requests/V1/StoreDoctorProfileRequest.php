<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'specialization' => ['required'],
            'license_number' => ['required'],
            'license_file_path' => ['required'],
            'diploma_file_path' => ['required'],
            'certification' => ['required'],
            'current_institution' => ['required'],
            //'years_of_experience' => ['required'],
            'work_history' => ['required'],
            'publications' => ['required'],
            'practice_address' => ['required'],
        ];
    }

    protected function prepareForValidation() {
        $data = [];

        foreach ($this->validated() as $key => $obj) {
            $obj['user_id'] = $obj['userId'] ??  null;
            $obj['license_number'] = $obj['licenseNumber'] ??  null;
            $obj['license_file_path'] = $obj['licenseFilePath'] ??  null;
            $obj['diploma_file_path'] = $obj['diplomaFilePath'] ??  null;
            $obj['current_institution'] = $obj['currentInstitution'] ??  null;
            //$obj['years_of_experience'] = $obj['yearsOfExperience'] ??  null;
            $obj['work_history'] = $obj['workHistory'] ??  null;
            $data[] = $obj;
        }
        $this->merge($data);

    }
}
