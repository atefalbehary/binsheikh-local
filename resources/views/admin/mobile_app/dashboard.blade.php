@extends('admin.template.layout')
@section('header')
    <style>
        /* Dark Theme Mobile Dashboard Styling */
        .mobile-dashboard-wrapper {
            background: #0a0a0a;
            background-image: radial-gradient(circle at 50% 50%, #1a1510 0%, #0a0a0a 100%);
            color: #ffffff;
            padding: 2rem;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            min-height: calc(100vh - 60px);
            margin: -1.5rem;
            /* negate default c-main padding */
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle starry background effect */
        .mobile-dashboard-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(2px 2px at 10% 20%, rgba(255, 215, 0, 0.15) 50%, transparent),
                radial-gradient(1.5px 1.5px at 80% 40%, rgba(255, 255, 255, 0.1) 50%, transparent),
                radial-gradient(2px 2px at 40% 80%, rgba(200, 160, 255, 0.1) 50%, transparent);
            background-size: 200px 200px;
            pointer-events: none;
            z-index: 0;
        }

        .md-header {
            position: relative;
            z-index: 1;
            margin-bottom: 2rem;
        }

        .md-title {
            font-size: 1.75rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }

        .md-subtitle {
            color: #8c8c8c;
            font-size: 0.95rem;
        }

        /* Stats Grid */
        .md-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .md-stat-card {
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .md-stat-card .bg-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .md-stat-value {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .md-stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }

        .md-stat-trend {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .trend-up {
            color: #a4f4d1;
        }

        .trend-down {
            color: #ffd1d1;
        }

        /* Specific Card Colors */
        .card-gold {
            background: linear-gradient(135deg, #8a6523 0%, #d4aa51 50%, #8a6523 100%);
            box-shadow: 0 4px 20px rgba(212, 170, 81, 0.15);
        }

        .card-dark {
            background: linear-gradient(135deg, #1c1c1e 0%, #2a2a2d 100%);
        }

        .card-purple {
            background: linear-gradient(135deg, #4b2361 0%, #804a9f 100%);
        }

        .card-green {
            background: linear-gradient(135deg, #182f25 0%, #294738 100%);
        }

        .card-blue {
            background: linear-gradient(135deg, #192a35 0%, #264354 100%);
        }

        /* Action Buttons */
        .md-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .md-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #d4aa51;
            /* Gold text */
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .md-btn:hover {
            background: rgba(212, 170, 81, 0.1);
            border-color: rgba(212, 170, 81, 0.3);
            color: #d4aa51;
            text-decoration: none;
        }

        .md-btn i {
            font-size: 1.1rem;
        }

        /* Recent Activity */
        .md-section-title {
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
            color: #ffffff;
            font-weight: 500;
        }

        .md-activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            position: relative;
            z-index: 1;
            margin-bottom: 1rem;
        }

        .md-activity-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.2s ease;
        }

        .md-activity-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .md-activity-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .md-activity-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-user {
            background: rgba(81, 145, 212, 0.15);
            color: #5191d4;
        }

        .icon-property {
            background: rgba(212, 170, 81, 0.15);
            color: #d4aa51;
        }

        .icon-price {
            background: rgba(163, 81, 212, 0.15);
            color: #a351d4;
        }

        .icon-visit {
            background: rgba(81, 145, 212, 0.15);
            color: #5191d4;
        }

        .md-activity-text h4 {
            margin: 0 0 0.25rem 0;
            font-size: 0.95rem;
            color: #ffffff;
            font-weight: 500;
        }

        .md-activity-text p {
            margin: 0;
            color: #8c8c8c;
            font-size: 0.85rem;
        }

        .md-activity-time {
            color: #8c8c8c;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .md-view-all {
            color: #d4aa51;
            font-size: 0.9rem;
            text-align: right;
            display: block;
            margin-top: 0.5rem;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .md-view-all:hover {
            color: #efca7a;
            text-decoration: underline;
        }

        /* Bottom Navigation */
        .md-bottom-nav {
            margin-top: 3rem;
            display: flex;
            gap: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .md-nav-item {
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .md-nav-item i {
            font-size: 1.1rem;
        }

        .md-nav-item:hover {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }

        .md-nav-item.active {
            color: #d4aa51;
            border-bottom-color: #d4aa51;
            background: linear-gradient(to top, rgba(212, 170, 81, 0.1) 0%, transparent 100%);
        }
    </style>
@endsection

@section('content')
    <div class="mobile-dashboard-wrapper">

        <div class="md-header">
            <h1 class="md-title">{{ $page_heading }}</h1>
            <div class="md-subtitle">Manage mobile users, content, notifications & automation</div>
        </div>

        <div class="md-stats-grid">
            <!-- Users -->
            <div class="md-stat-card card-gold">
                <i class="fas fa-mobile-alt bg-icon text-white"></i>
                <div>
                    <div class="md-stat-value">{{ number_format($mobile_users) }}</div>
                    <div class="md-stat-label">Mobile Users</div>
                </div>
                <div class="md-stat-trend trend-up">
                    + {{ $mobile_users_today }} Today
                </div>
            </div>

            <!-- Active Conversations -->
            <div class="md-stat-card card-dark">
                <i class="fas fa-comments bg-icon" style="color: #d4aa51;"></i>
                <div>
                    <div class="md-stat-value">{{ number_format($active_conversations) }}</div>
                    <div class="md-stat-label">Active Conversations</div>
                </div>
                <div class="md-stat-trend" style="color: #d4aa51;">
                    + 1385
                </div>
            </div>

            <!-- Notifications -->
            <div class="md-stat-card card-purple">
                <i class="fas fa-bell bg-icon text-white"></i>
                <div>
                    <div class="md-stat-value">{{ number_format($notifications_sent_today) }}</div>
                    <div class="md-stat-label">Notifications Sent today</div>
                </div>
                <div class="md-stat-trend trend-up" style="display:flex; justify-content:space-between">
                    <span>+ 32% Today</span>
                    <span class="trend-down">- 32%</span>
                </div>
            </div>

            <!-- Favorited -->
            <div class="md-stat-card card-green">
                <i class="fas fa-heart bg-icon" style="color: #6ed090;"></i>
                <div>
                    <div class="md-stat-value">{{ number_format($favorited_properties) }}</div>
                    <div class="md-stat-label">Favorited Properties</div>
                </div>
                <div class="md-stat-trend trend-up">
                    + 32% Today
                </div>
            </div>

            <!-- Scheduled Properties (Mock matches favorites count in image) -->
            <div class="md-stat-card card-green">
                <i class="fas fa-heart bg-icon" style="color: #6ed090;"></i>
                <div>
                    <div class="md-stat-value">{{ number_format($scheduled_properties) }}</div>
                    <div class="md-stat-label">Scheduled Properties</div>
                </div>
                <div class="md-stat-trend trend-up">
                    + 8% Today
                </div>
            </div>

            <!-- Scheduled Visits -->
            <div class="md-stat-card card-blue">
                <i class="fas fa-calendar-check bg-icon" style="color: #6ed1f4;"></i>
                <div>
                    <div class="md-stat-value">{{ number_format($scheduled_visits) }}</div>
                    <div class="md-stat-label">Scheduled Visits</div>
                </div>
                <div class="md-stat-trend trend-up" style="display:flex; justify-content:space-between">
                    <span>+ 5% Past 7 Days</span>
                    <span>+ 5% Past 7 Days</span>
                </div>
            </div>
        </div>

        <div class="md-actions">
            <a href="{{ url('admin/notifications/create') }}" class="md-btn">
                <i class="fas fa-plus"></i> Send Notification
            </a>
            <a href="{{ url('admin/projects/create') }}" class="md-btn">
                <i class="fas fa-building"></i> Add Project
            </a>
            <a href="{{ url('admin/popups') }}" class="md-btn">
                <i class="fas fa-bullhorn"></i> Create Pop-up
            </a>
            <a href="{{ url('admin/properties/create') }}" class="md-btn">
                <i class="fas fa-home"></i> Add Property
            </a>
        </div>

        <div>
            <h3 class="md-section-title">Recent Activity</h3>

            <div class="md-activity-list">
                @foreach($recent_users as $user)
                    <div class="md-activity-item">
                        <div class="md-activity-left">
                            <div class="md-activity-icon icon-user">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="md-activity-text">
                                <h4>New User Registered: <strong>{{ $user->name }}</strong></h4>
                                <p>{{ $user->email }} - {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="md-activity-time">
                            {{ $user->created_at->format('h:i A') }} <i class="fas fa-chevron-right ml-2"
                                style="font-size: 0.75rem;"></i>
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="{{ url('admin/users?role=2') }}" class="md-view-all">View All <i
                    class="fas fa-chevron-right ml-1"></i></a>
        </div>

        <!-- Bottom Tabs -->
        <div class="md-bottom-nav">
            <a href="{{ route('admin.mobile_app.index') }}" class="md-nav-item active">
                <i class="fas fa-home"></i> Overview
            </a>
            <a href="{{ url('admin/pages') }}" class="md-nav-item">
                <i class="fas fa-bullhorn"></i> Content Manager
            </a>
            <a href="{{ url('admin/projects') }}" class="md-nav-item">
                <i class="fas fa-building"></i> Projects
            </a>
            <a href="{{ url('admin/notifications') }}" class="md-nav-item">
                <i class="fas fa-bell"></i> Notification Center
            </a>
            <a href="{{ url('admin/users') }}" class="md-nav-item">
                <i class="fas fa-users"></i> Users
            </a>
        </div>

    </div>
@endsection

@section('script')
    <script>
        // Any necessary JS for the mobile dashboard goes here
    </script>
@endsection