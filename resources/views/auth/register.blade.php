@extends('layouts.app')

@section('content')

<style>
    /* Background */
    body {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        min-height: 100vh;
    }

    /* Card */
    .register-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    /* Header */
    .register-header {
        background: linear-gradient(135deg, #1cc88a, #4e73df);
        color: #fff;
        text-align: center;
        padding: 30px;
    }

    .register-header h3 {
        font-weight: 700;
    }

    /* Inputs */
    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, .25);
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        border: none;
        border-radius: 999px;
        padding: 10px 26px;
        font-weight: 600;
    }

    /* Labels */
    .col-form-label {
        font-weight: 600;
    }

    /* Animation */
    .register-card {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-weight: 500;
    }
</style>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-9 col-lg-7">

            <div class="card register-card">

                <!-- Header -->
                <div class="register-header">
                    <h3><i class="fas fa-user-plus me-2"></i> Create Account</h3>
                    <p class="mb-0 opacity-75">Register to access the Employee Management system</p>
                </div>

                <!-- Body -->
                <div class="card-body p-4">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="row mb-3 align-items-center">
                            <label for="name" class="col-md-4 col-form-label text-md-end">
                                {{ __('Name') }}
                            </label>
                            <div class="col-md-6">
                                <input id="name"
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name') }}"
                                    autocomplete="off"
                                    autofocus>

                                @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3 align-items-center">
                            <label for="email" class="col-md-4 col-form-label text-md-end">
                                {{ __('Email Address') }}
                            </label>
                            <div class="col-md-6">
                                <input id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3 align-items-center">
                            <label for="password" class="col-md-4 col-form-label text-md-end">
                                {{ __('Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                     <div class="row mb-3 align-items-center">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">
                        {{ __('Confirm Password') }}
                    </label>

                    <div class="col-md-6">
                        <input id="password-confirm"
                            type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation"
                            autocomplete="new-password">

                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                        <!-- Phone -->
                        <div class="row mb-3 align-items-center">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">
                                {{ __('contact_no') }}
                            </label>
                            <div class="col-md-6">
                               <input id="phone"
                                type="text"
                                class="form-control @error('contact_no') is-invalid @enderror"
                                name="contact_no"
                                value="{{ old('contact_no') }}">


                                @error('contact_no')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                     <div class="row mb-4 align-items-center">
                    <label for="role" class="col-md-4 col-form-label text-md-end">
                        {{ __('Role') }}
                    </label>

                    <div class="col-md-6">
                       <select id="role"
                        class="form-select @error('role') is-invalid @enderror"
                        name="role">

                        <option value="">Select Role</option>
                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>


                        @error('role')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                        <!-- Submit -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-primary shadow">
                                    <i class="fas fa-user-check me-2"></i> {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection