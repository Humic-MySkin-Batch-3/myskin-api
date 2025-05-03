<?php
namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDoctorRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        return [
            'name'               => ['required','string'],
            'email'              => ['required','email','unique:accounts,email'],
            'phone'              => ['required','string','unique:accounts,phone'],
            'password'           => ['required','string','min:8','confirmed'],

            'practice_address'   => ['required','string'],
            'specialization'     => ['required','string'],
            'license_number'     => ['required','string','unique:doctor_profiles,license_number'],
            'license_file'       => ['required','file','mimes:pdf,jpg,png','max:4096'],
            'diploma_file'       => ['required','file','mimes:pdf,jpg,png','max:4096'],
            'certification_file' => ['required','file','mimes:pdf,jpg,png','max:5120'],
            'current_institution'=> ['required','string'],
            'work_history'       => ['required','string'],
            'publications'       => ['sometimes','string'],
        ];
    }
}
