<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\AccountFilter;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\V1\StoreAccountRequest;
use App\Http\Requests\V1\UpdateAccountRequest;
use App\Http\Resources\V1\AccountCollection;
use App\Http\Resources\V1\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;


class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Account::class,'account');
    }
    public function index(Request $request)
    {
        $filter = new AccountFilter();
        $filterItems = $filter->transform($request);

        $includeSubmissions = $request->query('includeSubmissions');
        $includeDoctorProfiles = $request->query('includeDoctorProfiles');

        $accounts = Account::where($filterItems);

        if ($includeSubmissions) {
            $accounts = $accounts->with('submission');
        }
        if ($includeDoctorProfiles) {
            $accounts = $accounts->with('doctorProfile');
        }
        return new AccountCollection($accounts->paginate()->appends($request->query()));
    }

    public function welcome(Request $request)
    {
        $user = $request->user();

        $firstName = explode(' ', trim($user->name))[0] ?? $user->name;

        $id = $user->id;
        $role = ucfirst($user->role);
        $message = "Welcome back, {$firstName}! (You are logged in as {$role})";

        return response()->json([
            'accountId' => $id,
            'message'   => $message,
            'firstName' => $firstName,
            'role'      => $user->role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        //
        return new AccountResource(Account::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
        $includeSubmissions = request()->query('includeSubmissions');
        if ($includeSubmissions) {
            $account->loadMissing('submission');
        }
        $includeDoctorProfiles = request()->query('includeDoctorProfiles');
        if ($includeDoctorProfiles) {
            $account->loadMissing('doctorProfile');
        }
        return new AccountResource($account);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
        $account->update($request->validated());
        return new AccountResource($account->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
        $account->delete();
        return response()->json(['message' => 'Account deleted.']);
    }
}
