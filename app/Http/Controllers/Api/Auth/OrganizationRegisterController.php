<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganizationRegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'organization_name' => 'required|unique:organizations,name',
            'organization_email' => 'required|unique:organizations,email',
            'organization_address' => 'required',
            'brief_info' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $organization = Organization::create([
                'name' => $request->get('organization_name'),
                'slug' => Str::slug($request->get('organization_name')),
                'email' => $request->get('organization_email'),
                'address' => $request->get('organization_address'),
                'brief_info' => $request->get('brief_info'),
                'super_admin_id' => $user->id
            ]);

            $organization->users()->sync($user);

            DB::commit();

            $token = $user->createToken('app_token')->plainTextToken;
        } catch (Exception $e) {
            DB::rollBack();
            return response(["message" => "Account not registered. " . $e->getMessage()], 500);
        }

        return response(['user' => $user, 'organization' => $organization, 'token' => $token], 201);
    }
}
