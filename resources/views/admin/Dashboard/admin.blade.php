@extends('layouts.admin')

@section('title', 'Admin Dashboard')
<!-- @section('page-title', 'Admin Dashboard') -->

@section('content')

<style>
/* ========== ROOT VARIABLES ========== */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --bg-light: #f8fafc;
    --bg-lighter: #ffffff;
    --border-color: #e2e8f0;
    
    --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.08);
    --shadow-md: 0 8px 24px rgba(15, 23, 42, 0.12);
    --shadow-lg: 0 16px 48px rgba(15, 23, 42, 0.16);
}

/* ========== GLOBAL ========== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: var(--text-primary);
    font-family: 'Segoe UI', Trebuchet MS, sans-serif;
    min-height: 100vh;
    scroll-behavior: smooth;
}

body {
    overflow-x: hidden;
}

/* ========== PAGE HEADER ========== */
.page-header {
    animation: slideDown 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.page-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.5px;
    margin-bottom: 8px;
}

.page-header p {
    font-size: 15px;
    color: var(--text-secondary);
    font-weight: 500;
}

/* ========== STAT CARDS ========== */
.stat-card {
    border-radius: 20px;
    border: none;
    color: #fff;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
    position: relative;
    height: 100%;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: var(--shadow-md);
}

.stat-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        120deg,
        rgba(255, 255, 255, 0.25) 0%,
        rgba(255, 255, 255, 0) 60%
    );
    opacity: 0;
    transition: opacity 0.4s ease;
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-lg);
}

.stat-card .card-body {
    position: relative;
    z-index: 2;
}

.stat-card h6 {
    font-size: 13px;
    opacity: 0.85;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stat-card h3 {
    font-weight: 800;
    margin-top: 8px;
    font-size: 36px;
    letter-spacing: -1px;
}

/* Card Icons */
.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-right: 18px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: transform 0.3s ease;
}

.stat-card:hover .card-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Gradient Backgrounds */
.bg-total {
    background: var(--primary-gradient);
    position: relative;
}

.bg-total::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 100% 0%, rgba(255, 255, 255, 0.1), transparent 70%);
}

.bg-open {
    background: var(--info-gradient);
    position: relative;
}

.bg-open::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 100% 0%, rgba(255, 255, 255, 0.1), transparent 70%);
}

.bg-progress {
    background: var(--warning-gradient);
    position: relative;
}

.bg-progress::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 100% 0%, rgba(255, 255, 255, 0.1), transparent 70%);
}

.bg-closed {
    background: var(--success-gradient);
    position: relative;
}

.bg-closed::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 100% 0%, rgba(255, 255, 255, 0.1), transparent 70%);
}

/* Priority Gradients */
.bg-high {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8787 100%);
}

.bg-medium {
    background: linear-gradient(135deg, #ffa502 0%, #ffb84d 100%);
}

.bg-low {
    background: linear-gradient(135deg, #51cf66 0%, #69db7c 100%);
}

/* ========== CARDS ========== */
.card {
    border-radius: 20px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    background: var(--bg-lighter);
    overflow: hidden;
}

.card:hover {
    box-shadow: var(--shadow-md);
    border-color: #cbd5e1;
}

.card-header {
    border-bottom: 1px solid var(--border-color);
    background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);
    padding: 24px;
}

.card-header h5 {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 18px;
    letter-spacing: -0.3px;
}

.card-body {
    padding: 24px;
}

/* ========== TABLE ========== */
.table {
    margin-bottom: 0;
    border-collapse: collapse;
}

.table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    font-size: 12px;
    font-weight: 700;
    color: var(--text-secondary);
    border-bottom: 1px solid var(--border-color);
    padding: 16px 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: background 0.2s ease, box-shadow 0.2s ease;
    border-bottom: 1px solid var(--border-color);
}

.table tbody tr:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.04) 0%, transparent 100%);
    box-shadow: inset 0 0 12px rgba(102, 126, 234, 0.05);
}

.table td {
    font-size: 14px;
    vertical-align: middle;
    padding: 16px 12px;
    color: var(--text-primary);
}

.table td a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s ease;
}

.table td a:hover {
    color: #764ba2;
}

.table-light {
    opacity: 0.65;
}

/* ========== BADGES ========== */
.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.badge.bg-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
    color: white;
    box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
}

.badge.bg-secondary {
    background: linear-gradient(135deg, #c7d2e0 0%, #d6dce4 100%) !important;
    color: #475569;
}

.badge.bg-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8787 100%) !important;
    color: white;
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

.badge.bg-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
    color: white;
    box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
}

/* ========== BUTTONS ========== */
.btn-outline-primary {
    border-radius: 12px;
    font-size: 13px;
    padding: 8px 16px;
    border: 2px solid #667eea;
    color: #667eea;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
}

.btn-outline-primary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--primary-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    transform: translateY(-2px);
}

/* ========== ANIMATIONS ========== */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
    }
    50% {
        box-shadow: 0 0 0 8px rgba(102, 126, 234, 0);
    }
}

.stat-card {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

.card {
    animation: fadeInUp 0.6s ease-out 0.5s;
    animation-fill-mode: both;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .page-header h2 {
        font-size: 24px;
    }

    .stat-card h3 {
        font-size: 28px;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }

    .table {
        font-size: 12px;
    }

    .table td, .table th {
        padding: 12px 8px;
    }
}

/* ========== SCROLLBAR ========== */
::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

::-webkit-scrollbar-track {
    background: var(--bg-light);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}


</style>

<!-- Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="page-header">
            <h2 style = "color:navy">Dashboard Overview</h2>
            <p style ="color:green" class="text-muted">Welcome back to Employe Management! Here's your Employes recent activity</p>
        </div>
    </div>
</div>

<!-- Main Statistics -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-total" style="background: linear-gradient(135deg, #143e96 0%, #7d0dec 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Employees</h6>
                    <h3 class="mb-0">{{ $stats['total_employees'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-open " style="background: linear-gradient(135deg, #0a4579 0%, #15c930 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div>
                    <h6 class="mb-1">On Leave Today</h6>
                    <h3 class="mb-0">{{ $stats['on_leave_today'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-progress " style="background: linear-gradient(135deg, #a71b72 0%, #238bb0 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Departments</h6>
                    <h3 class="mb-0">{{ $stats['total_departments'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-closed" style="background: linear-gradient(135deg, #0c025c 0%, #c2a8dc 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h6 class="mb-1">Pending Approvals</h6>
                    <h3 class="mb-0">{{ $stats['pending_approvals'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Priority Stats -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-high" style="background: linear-gradient(135deg, #061142 0%, #8d45d5 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <h6 class="mb-1">Present Today</h6>
                    <h3 class="mb-0">{{ $stats['is_present_today'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-medium" style="background: linear-gradient(135deg, #031561 0%, #550e9b 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-align-center"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Announemnets</h6>
                    <h3 class="mb-0">{{ $stats['total_announcements'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card bg-low" style="background: linear-gradient(135deg, #023d5b 0%, #7f08f5 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div>
                    <h6 class="mb-1">Approved Leaves</h6>
                    <h3 class="mb-0">{{ $stats['approved_leaves'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card stat-card" style="background: linear-gradient(135deg, #0bf048 0%, #800ff1 100%); position: relative;">
            <div class="card-body d-flex align-items-center">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h6 class="mb-1">Pending PayRolls</h6>
                    <h3 class="mb-0">{{ ($stats['pending_payrolls'] ?? 0) + ($stats['total_agents'] ?? 0) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overview Cards -->
<div class="row g-4 mb-5">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 style ="color:navy" class="card-title mb-0">👥 Users Overview</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 py-3 border-end">
                        <h2 style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 8px;">
                            {{ $stats['total_customers'] ?? 0 }}
                        </h2>
                        <p class="text-muted mb-0">Total Customers</p>
                    </div>
                    <div class="col-6 py-3">
                        <h2 style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 8px;">
                            {{ $stats['total_agents'] ?? 0 }}
                        </h2>
                        <p class="text-muted mb-0">Total Agents</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 style ="color:navy" class="card-title mb-0">📊 Tickets by Priority</h5>
            </div>
            <div class="card-body">
                @if(!empty($stats['tickets_by_priority']))
                    @foreach($stats['tickets_by_priority'] as $priority => $count)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="text-capitalize fw-600">{{ str_replace('-', ' ', $priority) }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px; width: 50%;">
                                <div style="flex: 1; height: 8px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                                    <div style="height: 100%; width: {{ ($count / max($stats['tickets_by_priority'])) * 100 }}%; background: var(--primary-gradient); transition: width 0.3s ease;"></div>
                                </div>
                                <strong style="min-width: 40px; text-align: right;">{{ $count }}</strong>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No tickets yet</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style ="color:navy" class="card-title mb-0">📋 Recent Tickets</h5>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-outline-primary">
            View All <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Agent</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($stats['recent_tickets'] as $ticket)
                        <tr class="{{ $ticket->status?->name === 'Closed' ? 'table-light' : '' }}">
                            <td>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}">
                                    #{{ $ticket->id }}
                                </a>
                            </td>
                            <td>
                                <span title="{{ $ticket->subject }}">
                                    {{ \Illuminate\Support\Str::limit($ticket->subject, 40) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted" title="{{ $ticket->description }}">
                                    {{ \Illuminate\Support\Str::limit($ticket->description, 50) }}
                                </span>
                            </td>
                            <td>
                                @if($ticket->assignedAgent)
                                    <span class="badge bg-info">
                                        {{ $ticket->assignedAgent->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Unassigned
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->status)
                                    <span class="badge bg-secondary">
                                        {{ $ticket->status->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->priority)
                                    @if($ticket->priority->name === 'High')
                                        <span class="badge bg-danger">{{ $ticket->priority->name }}</span>
                                    @elseif($ticket->priority->name === 'Medium')
                                        <span class="badge" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">{{ $ticket->priority->name }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $ticket->priority->name }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $ticket->created_at?->format('M d, Y') }}
                                </small>
                            </td>
                            <td>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div style="color: var(--text-secondary);">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                    <p style="font-weight: 500;">No tickets found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection