<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:admin,employee'],
        'contact_no' => ['nullable', 'digits:10'],
    ]);

    $role = $request->role ?? 'employee';

    $user = User::create([
        'name'=> $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'contact_no' => $request->contact_no,
        'role' => $role,
        'status' => 'active',
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Role-based redirect
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/employee/dashboard');
}

}
