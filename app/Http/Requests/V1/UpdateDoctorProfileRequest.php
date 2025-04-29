<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorProfileRequest extends FormRequest
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
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'userId' => ['required'],
                'specialization' => ['required'],
                'licenseNumber' => ['required'],
                'licenseFilePath' => ['required'],
                'diplomaFilePath' => ['required'],
                'certification' => ['required'],
                'currentInstitution' => ['required'],
                //'yearsOfExperience' => ['required'],
                'workHistory' => ['required'],
                'publications' => ['required']
            ];
        } else {
            return [
                'userId' => ['sometimes', 'required'],
                'specialization' => ['sometimes', 'required'],
                'licenseNumber' => ['sometimes', 'required'],
                'licenseFilePath' => ['sometimes', 'required'],
                'diplomaFilePath' => ['sometimes', 'required'],
                'certification' => ['sometimes', 'required'],
                'currentInstitution' => ['sometimes', 'required'],
                //'yearsOfExperience' => ['sometimes', 'required'],
                'workHistory' => ['sometimes', 'required'],
                'publications' => ['sometimes', 'required'],
                'practice_address' => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        $data['user_id'] = $data['userId'] ?? $data['user_id'] ??  null;
        $data['license_number'] = $data['licenseNumber'] ?? $data['license_number'] ??  null;
        $data['license_file_path'] = $data['licenseFilePath'] ?? $data['license_file_path'] ??  null;
        $data['diploma_file_path'] = $data['diplomaFilePath'] ?? $data['diploma_file_path'] ??  null;
        $data['current_institution'] = $data['currentInstitution'] ?? $data['current_institution'] ??  null;
        //$data['years_of_experience'] = $data['yearsOfExperience'] ?? $data['years_of_experience'] ??  null;
        $data['work_history'] = $data['workHistory'] ?? $data['work_history'] ??  null;

        $this->merge($data);

    }
}
