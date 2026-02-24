<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{

public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'       => 'required|string|max:255',
        'email'      => 'required|string|email|max:255|unique:users,email',
        'password'   => 'required|string|min:8',
        'contact_no' => 'nullable|digits:10',
        'role'       => 'required|in:admin,employee'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validation Error',
            'errors'  => $validator->errors()
        ], 422);
    }

     try {
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'contact_no' => $request->contact_no,
            'role'       => $request->role
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User Registered Successfully',
            'data'    => $user
        ], 201);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong',
        ], 500);
    }
}
}
