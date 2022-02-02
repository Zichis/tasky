<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'organization_brief_info' => 'nullable'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $organization = Organization::create([
            'name' => $request->get('organization_name'),
            'email' => $request->get('organization_email'),
            'address' => $request->get('organization_address'),
            'brief_info' => $request->get('organization_brief_info'),
            'super_admin_id' => $user->id
        ]);

        $user->update(['organization_id' => $organization->id]);

        $token = $user->createToken('app_token')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);
    }
}
