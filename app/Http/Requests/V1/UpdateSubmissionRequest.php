<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubmissionRequest extends FormRequest
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
                'patientId' => ['required'],
                'doctorId' => ['required'],
                'image'      => ['sometimes','image','max:2048'],
                'complaint' => ['required'],
                'status' => ['required', Rule::in(['pending', 'verified', 'rejected'])],
                'diagnosis' => ['required'],
                'doctorNote' => ['required'],
                'submittedAt' => ['required'],
                'verifiedAt' => ['required'],
            ];
        } else {
            return [
                'patientId' => ['sometimes', 'required'],
                'doctorId' => ['sometimes', 'required'],
                'image'      => ['sometimes','image','max:2048'],
                'complaint' => ['sometimes', 'required'],
                'status' => ['sometimes', 'required', Rule::in(['pending', 'verified', 'rejected'])],
                'diagnosis' => ['sometimes', 'required'],
                'doctorNote' => ['sometimes', 'required'],
                'submittedAt' => ['sometimes', 'required'],
                'verifiedAt' => ['sometimes', 'required'],
            ];
        }
    }

    /*protected function prepareForValidation()
    {
        $data = $this->all();
        $data['patient_id'] = $data['patientId'] ?? $data['patient_id'] ?? null;
        $data['doctor_id'] = $data['doctorId'] ?? $data['doctor_id'] ?? null;
        $data['image_path'] = $data['imagePath'] ?? $data['image_path'] ?? null;
        $data['complaint'] = $data['complaint'] ?? $data['complaint'] ?? null;
        $data['submitted_at'] = $data['submittedAt'] ?? $data['submitted_at'] ?? null;
        $data['verified_at'] = $data['verifiedAt'] ?? $data['verified_at'] ?? null;

        $this->merge($data);
    }*/

}
