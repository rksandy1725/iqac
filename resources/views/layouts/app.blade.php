<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IQAC Management') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #f1f5f9; }

        .sidebar {
            min-height: 100vh;
            width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.2rem;
        }

        .sidebar-brand-text {
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.3px;
        }

        .sidebar-nav { padding: 1rem 0.75rem; }

        .sidebar-section-label {
            color: rgba(255,255,255,0.35);
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.5rem 0.75rem 0.35rem;
            margin-top: 0.5rem;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            margin: 1px 0;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(59, 130, 246, 0.2);
            border-left: 3px solid #3b82f6;
            padding-left: calc(0.85rem - 3px);
        }

        .sidebar .nav-link i {
            font-size: 1.05rem;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }

        .main-content {
            margin-left: 260px;
            padding: 0;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            padding: 0.85rem 1.75rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }

        .topbar-date {
            color: #64748b;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.85rem; font-weight: 600;
        }

        .user-menu-btn {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.35rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-menu-btn:hover { border-color: #cbd5e1; background: #f8fafc; }

        .page-content { padding: 1.75rem; }

        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }

        .card-stat:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .card-stat .card-body { padding: 1.25rem; }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
        }

        .section-title { font-size: 1rem; font-weight: 700; color: #1e293b; letter-spacing: -0.3px; }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
        }

        .list-group-item {
            border-color: #f1f5f9;
            padding: 0.85rem 1.25rem;
        }

        .list-group-item:hover { background: #f8fafc; }

        .badge {
            font-weight: 500;
            font-size: 0.72rem;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        @media (max-width: 991px) {
            .sidebar { width: 70px; }
            .sidebar .nav-link span,
            .sidebar-brand-text,
            .sidebar-section-label { display: none; }
            .sidebar .nav-link { justify-content: center; padding: 0.65rem; }
            .sidebar .nav-link i { margin: 0; font-size: 1.2rem; }
            .sidebar-brand { justify-content: center; padding: 1.25rem 0.5rem; }
            .sidebar-nav { padding: 1rem 0.5rem; }
            .main-content { margin-left: 70px; }
        }
    </style>
</head>
<body>
    @auth
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <span class="sidebar-brand-text">IQAC Management</span>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>
                <a class="nav-link {{ request()->routeIs('criteria.*') ? 'active' : '' }}" href="{{ route('criteria.index') }}">
                    <i class="bi bi-list-check"></i><span>NAAC Criteria</span>
                </a>
                <a class="nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}" href="{{ route('activities.index') }}">
                    <i class="bi bi-clipboard-data"></i><span>Activities</span>
                </a>
            </nav>
            <div class="sidebar-section-label">Management</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('meetings.*') ? 'active' : '' }}" href="{{ route('meetings.index') }}">
                    <i class="bi bi-calendar-event"></i><span>Meetings</span>
                </a>
                <a class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                    <i class="bi bi-file-earmark-text"></i><span>Documents</span>
                </a>
                <a class="nav-link {{ request()->routeIs('feedback.*') ? 'active' : '' }}" href="{{ route('feedback.index') }}">
                    <i class="bi bi-chat-dots"></i><span>Feedback</span>
                </a>
            </nav>
            <div class="sidebar-section-label">Reports</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('aqar.*') ? 'active' : '' }}" href="{{ route('aqar.index') }}">
                    <i class="bi bi-file-earmark-bar-graph"></i><span>AQAR Reports</span>
                </a>
            </nav>
            @if(auth()->user()->isAdmin())
            <div class="sidebar-section-label">Administration</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i><span>Users</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" href="{{ route('admin.departments.index') }}">
                    <i class="bi bi-building"></i><span>Departments</span>
                </a>
            </nav>
            @endif
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <span class="text-muted small">Welcome, <strong class="text-dark">{{ auth()->user()->name }}</strong></span>
                <span class="badge bg-primary-subtle text-primary">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
            <div class="topbar-right">
                <span class="topbar-date">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->format('D, d M Y') }}
                </span>
                <div class="dropdown">
                    <button class="user-menu-btn" data-bs-toggle="dropdown" data-bs-auto-close="true">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <i class="bi bi-chevron-down text-muted" style="font-size:0.7rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-1" style="border-radius:10px;min-width:180px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold text-dark" style="font-size:0.88rem;">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ auth()->user()->email }}</div>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2 text-muted"></i>My Profile</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content">
            {{ $slot }}
        </div>
    </div>
    @else
        {{ $slot }}
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
