<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div style="margin-bottom: 1.5rem; color: #059669; background-color: #d1fae5; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.875rem;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            @error('email')
                <span class="text-danger" style="display: block; margin-top: 0.25rem; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <span class="text-danger" style="display: block; margin-top: 0.25rem; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <label for="remember_me" style="display: flex; align-items: center; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 0.5rem; accent-color: var(--primary-color); width: 1rem; height: 1rem;">
                <span style="font-size: 0.875rem; color: var(--text-secondary);">Remember me</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: var(--primary-color); text-decoration: none; font-weight: 600;">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 0.875rem;">
            Sign In
        </button>
    </form>
    
    <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: var(--text-tertiary);">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</x-guest-layout>
