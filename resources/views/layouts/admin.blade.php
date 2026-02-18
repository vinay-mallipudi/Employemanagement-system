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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">




    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="brand-title">
                <i class="fas fa-layer-group"></i> EMS Admin
            </a>
        </div>
        
        <nav class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            @if(Auth::user()->isAdmin())
            <div class="menu-label">System Management</div>
            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Employees</span>
            </a>
            
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i>
                <span>Departments</span>
            </a>
            @endif

            <div class="menu-label">Operations</div>
            <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Attendance</span>
            </a>

            <a href="{{ route('leaves.index') }}" class="nav-link {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i>
                <span>Leaves</span>
            </a>
            
            <a href="{{ route('payroll.index') }}" class="nav-link {{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Payroll</span>
            </a>
            
            <a href="{{ route('announcements.index') }}" class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i>
                <span>Announcements</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-bars menu-toggle" id="menu-toggle" style="font-size: 1.25rem; cursor: pointer; color: #6b7280; display: none;"></i>
                <div class="header-welcome">
                    <h2>Welcome Back, {{ Auth::user()->name }}</h2>
                    <p>Here's what's happening with your organization today.</p>
                </div>
            </div>
            
            <div class="header-right">
                <button style="border: none; background: none; font-size: 1.25rem; color: #6b7280; cursor: pointer;">
                    <i class="far fa-bell"></i>
                </button>
                
                <div class="user-profile">
                    <div class="avatar-circle">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div style="text-align: left;">
                        <span style="display: block; font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">{{ Auth::user()->name }}</span>
                        <span style="display: block; font-size: 0.75rem; color: var(--text-secondary);">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>
                
                 <form method="POST" action="{{ route('logout') }}" style="margin-left: 1rem;">
                    @csrf
                    <button type="submit" style="border: 1px solid #e5e7eb; background: white; padding: 0.5rem; border-radius: 0.5rem; cursor: pointer; color: #ef4444;">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <div style="padding: 2rem;">
             @if(session('success'))
                <div style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Mobile Sidebar Toggle -->
    <style>
        @media (max-width: 768px) {
            #menu-toggle { display: block !important; }
        }
    </style>
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
