<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/v1/auth/register
    public function register(RegisterRequest $req)
    {
        $data = $req->validated();
        $data['password'] = Hash::make($data['password']);
        $account = Account::create($data);

        // Jika role doctor, Anda bisa langsung buat profil dokternya:
        if($data['role']==='doctor'){
            $account->doctorProfile()->create([

            ]);
        }

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
