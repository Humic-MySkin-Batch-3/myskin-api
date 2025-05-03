<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterDoctorRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Models\Account;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/v1/auth/register/doctor
    public function registerDoctor(RegisterDoctorRequest $request)
    {

        $acct = Account::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'doctor',
            'password' => Hash::make($request->password),
        ]);

        $licensePath = $request->file('license_file')
            ->store('doctor_profiles/licenses','public');
        $diplomaPath = $request->file('diploma_file')
            ->store('doctor_profiles/diplomas','public');
        $certPath = $request->file('certification_file')
            ->store('doctor_profiles/certifications','public');

        $profile = DoctorProfile::create([
            'user_id'             => $acct->id,
            'specialization'      => $request->specialization,
            'license_number'      => $request->license_number,
            'license_file_path'   => $licensePath,
            'diploma_file_path'   => $diplomaPath,
            'certification_file_path' => $certPath,
            'current_institution' => $request->current_institution,
            'work_history'        => $request->work_history,
            'publications'        => $request->publications,
            'practice_address'    => $request->practice_address,
        ]);

        $token = $acct->createToken('doctor-token', ['create','update','delete'])->plainTextToken;

        return response()->json([
            'data' => [
                'account' => [
                    'id'    => $acct->id,
                    'name'  => $acct->name,
                    'email' => $acct->email,
                    'phone' => $acct->phone,
                ],
                'profile' => [
                    'specialization'      => $profile->specialization,
                    'licenseNumber'       => $profile->license_number,
                    'licenseFileUrl'      => asset("storage/{$profile->license_file_path}"),
                    'diplomaFileUrl'      => asset("storage/{$profile->diploma_file_path}"),
                    'certificationUrl' => asset("storage/{$profile->certification_file_path}"),
                    'currentInstitution'  => $profile->current_institution,
                    'workHistory'         => $profile->work_history,
                    'publications'        => $profile->publications,
                    'practiceAddress'     => $profile->practice_address,
                ],
                'token' => $token,
            ]
        ], 201);
    }

    // POST /api/v1/auth/register/patient
    public function register(RegisterRequest $req)
    {
        $data = $req->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'patient';
        $account = Account::create($data);

        $token = $account->createToken('auth-token')->plainTextToken;

        return response()->json([
            'data'  => $account,
            'token' => $token
        ], 201);
    }

    // POST /api/v1/auth/login
    public function login(LoginRequest $req)
    {
        $creds = $req->validated();
        $account = Account::where('email', $creds['email'])->first();

        if (!$account || !Hash::check($creds['password'], $account->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $account->createToken('auth-token')->plainTextToken;
        return response()->json([
            'data'  => $account,
            'token' => $token
        ]);
    }

    // POST /api/v1/auth/logout
    public function logout(Request $req)
    {
        // Hapus token yang dipakai saat ini
        $req->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }
}
