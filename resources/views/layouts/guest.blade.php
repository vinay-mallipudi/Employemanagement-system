<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Employee Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Styles -->
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-image: 
                    radial-gradient(at 0% 0%, rgba(255, 107, 53, 0.15) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.1) 0px, transparent 50%);
            }
            
            .auth-card {
                padding: 3rem;
                width: 100%;
                max-width: 450px;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(20px);
                border-radius: 1.5rem;
                box-shadow: 
                    0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                    0 10px 10px -5px rgba(0, 0, 0, 0.04),
                    0 0 0 1px rgba(255, 255, 255, 0.5) inset;
                animation: slideUp 0.5s ease-out forwards;
            }
            
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .auth-logo {
                display: flex;
                justify-content: center;
                margin-bottom: 2rem;
                color: var(--primary-color);
                font-size: 3rem;
            }
            
            .auth-title {
                text-align: center;
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: var(--text-primary);
            }
            
            .auth-subtitle {
                text-align: center;
                color: var(--text-tertiary);
                margin-bottom: 2.5rem;
                font-size: 0.95rem;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-card">
            <div class="auth-logo">
                <i class="fas fa-cube"></i>
            </div>
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your account to continue</p>
            
            {{ $slot }}
        </div>
    </body>
</html>
