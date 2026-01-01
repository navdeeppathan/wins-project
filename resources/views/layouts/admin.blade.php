<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project OverView (P.O.V.)</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 240px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --bg-dark: #111827;
            --bg-darker: #0d1117;
            --bg-card: #1f2937;
            --bg-card-hover: #374151;
            --text-light: #f9fafb;
            --text-muted: #9ca3af;
            --text-secondary: #6b7280;
            --border-color: #374151;
            --hover-bg: #374151;
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.15);
            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.15);
            --warning: #f59e0b;
            --warning-bg: rgba(245, 158, 11, 0.15);
            --purple: #8b5cf6;
            --purple-bg: rgba(139, 92, 246, 0.15);
            --cyan: #06b6d4;
            --cyan-bg: rgba(6, 182, 212, 0.15);
            --orange: #f97316;
            --orange-bg: rgba(249, 115, 22, 0.15);
        }

        /* Light mode variables */
        .mode-light {
            --bg-dark: #ffffff;
            --bg-darker: #f3f4f6;
            --bg-card: #ffffff;
            --bg-card-hover: #f9fafb;
            --text-light: #111827;
            --text-muted: #6b7280;
            --text-secondary: #9ca3af;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-darker);
            color: var(--text-light);
            overflow-x: hidden;
            line-height: 1.5;
            transition: background 0.3s, color 0.3s;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--bg-dark);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 2px;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        .logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .brand-name {
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
            transition: opacity 0.3s;
            color: var(--text-light);
        }

        .sidebar.collapsed .brand-name {
            opacity: 0;
            width: 0;
        }

        .collapse-btn {
            margin-left: auto;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.5rem;
            transition: 0.3s;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .collapse-btn:hover {
            background: var(--hover-bg);
            color: var(--text-light);
        }

        .sidebar.collapsed .collapse-btn {
            transform: rotate(180deg);
        }

        /* Navigation */
        .sidebar-nav {
            padding: 0.75rem 0;
            flex: 1;
        }

        .nav-section {
            margin-bottom: 0.5rem;
        }

        .nav-section-title {
            padding: 0.75rem 1rem 0.5rem;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
        }

        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .nav-item {
            margin: 0.125rem 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 0.75rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s ease;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--hover-bg);
            color: var(--text-light);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .nav-icon svg {
            width: 18px;
            height: 18px;
        }

        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        .nav-text {
            white-space: nowrap;
            transition: opacity 0.3s;
            flex: 1;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
        }

        /* Dropdown Arrow */
        .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.2s ease;
            font-size: 0.625rem;
        }

        .dropdown-arrow svg {
            width: 12px;
            height: 12px;
        }

        .nav-item.open .dropdown-arrow {
            transform: rotate(180deg);
        }

        .sidebar.collapsed .dropdown-arrow {
            opacity: 0;
        }

        /* Dropdown Menu */
        .sidebar-dropdown {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            margin-left: 0.5rem;
        }

        .nav-item.open .sidebar-dropdown {
            max-height: 500px;
        }

        .sidebar.collapsed .sidebar-dropdown {
            display: none;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem 0.5rem 2.5rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.15s ease;
            margin: 0.125rem 0;
            font-size: 0.7rem;
        }

        .dropdown-item:hover {
            background: var(--hover-bg);
            color: var(--text-light);
        }

        .dropdown-item.active {
            background: rgba(59, 130, 246, 0.15);
            color: var(--primary-color);
        }

        /* User Profile at Bottom */
        .sidebar-footer {
            padding: 0.75rem;
            border-top: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .user-info:hover {
            background: var(--hover-bg);
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
            flex-shrink: 0;
            color: white;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar.collapsed .user-details {
            display: none;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: var(--bg-darker);
        }

        .sidebar.collapsed ~ .main-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Bar */
        .topbar {
            background: var(--bg-dark);
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            background: var(--bg-darker);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 0.875rem;
            font-family: inherit;
            transition: border-color 0.15s;
        }

        .search-box input::placeholder {
            color: var(--text-secondary);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .search-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            width: 16px;
            height: 16px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.15s;
        }

        .icon-btn:hover {
            background: var(--hover-bg);
            color: var(--text-light);
        }

        .icon-btn svg {
            width: 20px;
            height: 20px;
        }

        .icon-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--bg-dark);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.375rem 0.75rem 0.375rem 0.375rem;
            background: var(--bg-card);
            border-radius: 24px;
            cursor: pointer;
            margin-left: 0.5rem;
            transition: background 0.15s;
        }

        .user-profile:hover {
            background: var(--bg-card-hover);
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.6875rem;
            color: white;
        }

        .user-profile-text {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-light);
        }

        .status-badge {
            font-size: 0.625rem;
            padding: 0.125rem 0.375rem;
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
            border-radius: 4px;
            font-weight: 600;
            margin-left: 0.25rem;
        }

        /* Content */
        .content {
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--text-light);
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Action Cards */
        .action-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .action-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-card:hover {
            transform: translateY(-2px);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .action-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .action-icon svg {
            width: 22px;
            height: 22px;
        }

        .action-card:nth-child(1) .action-icon {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .action-card:nth-child(2) .action-icon {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .action-card:nth-child(3) .action-icon {
            background: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
        }

        .action-card:nth-child(4) .action-icon {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        .action-card h3 {
            font-size: 0.9375rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-light);
        }

        .action-card p {
            color: var(--text-muted);
            font-size: 0.8125rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: rgba(6, 182, 212, 0.15);
            color: #06b6d4;
        }

        .stat-card:nth-child(3) .stat-icon {
            background: rgba(249, 115, 22, 0.15);
            color: #f97316;
        }

        .stat-card:nth-child(4) .stat-icon {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .stat-card:nth-child(5) .stat-icon {
            background: rgba(236, 72, 153, 0.15);
            color: #ec4899;
        }

        .stat-card:nth-child(6) .stat-icon {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .stat-change {
            font-size: 0.6875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.125rem;
        }

        .stat-change.positive {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .stat-change.negative {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--text-light);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .stat-meta {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Chart Card */
        .chart-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .chart-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .chart-icon {
            width: 40px;
            height: 40px;
            background: rgba(59, 130, 246, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

        .chart-icon svg {
            width: 20px;
            height: 20px;
        }

        .chart-title-text h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.125rem;
            color: var(--text-light);
        }

        .chart-title-text p {
            font-size: 0.8125rem;
            color: var(--text-muted);
        }

        .chart-legend {
            display: flex;
            gap: 1.5rem;
            font-size: 0.8125rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .chart-container {
            position: relative;
            height: 280px;
        }

        /* Mobile */
        .mobile-menu-btn {
            display: none;
            background: var(--primary-color);
            border: none;
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            cursor: pointer;
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 1001;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
            font-size: 1.25rem;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .overlay.active {
            opacity: 1;
        }

        @media (max-width: 1400px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .overlay {
                display: block;
            }

            .action-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .content {
                padding: 1rem;
            }

            .action-cards,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0.75rem 1rem;
            }

            .search-box {
                max-width: 200px;
            }

            .user-profile-text,
            .status-badge {
                display: none;
            }
        }
    </style>


    <style>


            /* ================= WRAPPER ================= */
            .table-responsive {
                border-radius: 14px;
                overflow: hidden;
                background: #fff;
                padding: 10px;
                cursor: pointer;
            }

            /* ================= HEADER ================= */
            .dataTables_scrollHead thead th,
            .class-table thead th {
                background: #6f7ae0 !important;
                color: #ffffff !important;
                font-weight: 600;
                font-size: 14px;
                padding: 14px 16px;
                border: none !important;


            }

            /* ================= CRITICAL FIX ================= */
            /* OVERRIDE BOOTSTRAP 5 TABLE BACKGROUND */
            .table.class-table > :not(caption) > tbody > tr:nth-child(odd) > * {
                background-color: #f7f8ff !important;
            }

            .table.class-table > :not(caption) > tbody > tr:nth-child(even) > * {
                background-color: #ffffff !important;
            }

            .table.class-table > :not(caption) > tbody > tr:hover > * {
                background-color: #c6ccfd !important;
            }

            /* ================= BODY CELLS ================= */
            .table.class-table tbody td {
                padding: 14px 16px;
                font-size: 13px;
                color: #555;
                border: none !important;
                vertical-align: middle;
            }

            /* ================= BUTTON ================= */
            .class-table .btn-success {
                border-radius: 20px;
                padding: 4px 14px;
                font-size: 12px;
            }

            /* ================= BADGE ================= */
            .class-table .badge {
                border-radius: 12px;
                padding: 6px 10px;
                font-size: 12px;
            }

            /* ================= PAGINATION ================= */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                background: #f0f2ff !important;
                border: none !important;
                border-radius: 6px !important;
                margin: 0 3px;
                padding: 6px 12px !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #6f7ae0 !important;
                color: #fff !important;
            }

            /* ================= SEARCH ================= */
            .dataTables_filter input {
                border-radius: 20px;
                padding: 6px 12px;
                border: 1px solid #ddd;
            }

            /* ================= SCROLL ================= */
            .dataTables_scrollBody {
                max-height: 420px;
            }

            /* ================= OPTIONAL: ROUNDED ROWS ================= */
            .table.class-table tbody tr td:first-child {
                border-top-left-radius: 8px;
                border-bottom-left-radius: 8px;
            }

            .table.class-table tbody tr td:last-child {
                border-top-right-radius: 8px;
                border-bottom-right-radius: 8px;
            }

    </style>

<style>
    /* 🔥 Allow full width inputs */
    #example input.form-control,
    #example select.form-select {
        min-width: 180px;
        width: 100%;
    }

    /* 🔥 Paid To & Narration extra wide */
    #example td:nth-child(3) input,
    #example td:nth-child(5) input {
        min-width: 250px;
    }

    /* 🔥 Disable text cutting */
    #example input,
    #example select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* 🔥 Horizontal scroll inside input */
    #example input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    #example input::-webkit-scrollbar {
        height: 6px;
    }
</style>

<style>
    /* 🔥 Allow full width inputs */
    .example input.form-control,
    .example select.form-select {
        min-width: 180px;
        width: 100%;
    }

    /* 🔥 Paid To & Narration extra wide */
    .example td:nth-child(3) input,
    .example td:nth-child(5) input {
        min-width: 250px;
    }

    /* 🔥 Disable text cutting */
    .example input,
    .example select {
        white-space: nowrap;
        overflow-x: auto;
    }

    /* 🔥 Horizontal scroll inside input */
    .example input {
        text-overflow: clip;
    }

    /* Optional: show scrollbar only when needed */
    .example input::-webkit-scrollbar {
        height: 6px;
    }
</style>

  @stack('styles')
</head>
<body class="mode-dark">
    <button class="mobile-menu-btn" onclick="toggleMobile()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div class="overlay" onclick="toggleMobile()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            {{-- <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div> --}}
            <span class="brand-name">Project OverView (P.O.V.)</span>
            <button class="collapse-btn" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ url('/admin') }}"
                class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>
                    <span class="nav-text">DASHBOARD</span>
                </a>
            </div>




            <div class="nav-item">
                <a href="{{ route('admin.projects.index') }}"
                class="nav-link {{ Request::is('admin/projects*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">PROJECTS (BIDDING)</span>
                </a>
            </div>


            <div class="nav-item">
                <a href="{{ route('admin.projects.acceptance') }}"
                class="nav-link {{ Request::is('admin/acceptance*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">PROJECTS (ACCEPTANCE)</span>
                </a>
            </div>

             <div class="nav-item">
                <a href="{{ route('admin.projects.award') }}"
                class="nav-link {{ Request::is('admin/award*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">PROJECTS (AWARD)</span>
                </a>
            </div>




            <div class="nav-item">
                <a href="{{ route('admin.activities.index') }}"
                class="nav-link {{ Request::is('admin/activities*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">MILSTONE</span>

                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.schedule-work.index') }}"
                class="nav-link {{ Request::is('admin/schedule-work*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">BILL OF QUANTITY</span>

                </a>
            </div>
{{--
            <div class="nav-item">
                <a href="{{ route('admin.schedule-work.index') }}"
                class="nav-link {{ Request::is('admin/schedule-work*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">ANALYSE OF RATE</span>

                </a>
            </div> --}}

            {{-- <div class="nav-item">
                <a href="{{ route('admin.schedule-work.index') }}"
                class="nav-link {{ Request::is('admin/schedule-work*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">ESTIMATION</span>

                </a>
            </div> --}}

            {{-- <div class="nav-item">
                <a href="{{ route('admin.schedule-work.index') }}"
                class="nav-link {{ Request::is('admin/schedule-work*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">BILL OF QUANTITY</span>

                </a>
            </div> --}}

            <div class="nav-item">
                <a href="{{ route('admin.projects.agreement') }}"
                class="nav-link {{ Request::is('admin/agreement*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">PROJECTS (AGREEMENT)</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{url('/admin/bill')}}"
                class="nav-link {{ Request::is('admin/bill*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">BILLING</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.projects.correspondence.index') }}"
                class="nav-link {{ Request::is('admin/correspondence*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">CORRESPONDENCE</span>
                </a>
            </div>

            {{-- <div class="nav-item">
                <a href=""
                class="nav-link ">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">COMPLETION</span>
                </a>
            </div> --}}


            <div class="nav-item">
                <a href="{{ route('admin.inventory.tabindex') }}"
                class="nav-link {{ Request::is('admin/inventory/tab') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">INVENTORY</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleDropdown(this)">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>
                    <span class="nav-text">SECURITIES</span>
                    <span class="dropdown-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </a>
                <div class="sidebar-dropdown">
                    <a href="{{ route('admin.projects.returned.index') }}" class="dropdown-item nav-link {{ Request::is('admin/emd*') ? 'active' : '' }}">EMD</a>

                    <a href="{{ route('admin.projects.pgreturned.index') }}" class="dropdown-item {{ Request::is('admin/pg*') ? 'active' : '' }}">PG</a>

                    <a href="{{ route('admin.projects.securityreturned.index') }}" class="dropdown-item {{ Request::is('admin/security*') ? 'active' : '' }}">SECURITY DEPOSIT</a>

                    <a href="{{ route('admin.projects.withheldreturned.index') }}" class="dropdown-item {{ Request::is('admin/withheld*') ? 'active' : '' }}">WITHHELD</a>
                </div>
            </div>

             <div class="nav-item">
                {{-- <a href="{{ route('admin.t-and-p.index') }}" --}}
                <a href="{{ route('admin.materialTabs.index') }}"

                class="nav-link {{ Request::is('admin/t-and-p*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">MATERIAL</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleDropdown(this)">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>
                    <span class="nav-text">ESTABLISHMENT</span>
                    <span class="dropdown-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </a>
                <div class="sidebar-dropdown">
                    <a href="{{ route('departments.index') }}" class="dropdown-item {{ Request::is('departments*') ? 'active' : '' }}">DEPARTMENTS</a>
                    <a href="{{ route('admin.vendors.index') }}" class="dropdown-item {{ Request::is('admin/vendors*') ? 'active' : '' }}">VENDORS</a>
                    <a href="{{ route('admin.users.index') }}"class="dropdown-item {{ Request::is('admin/users*') ? 'active' : '' }}">STAFF</a>
                </div>
            </div>


            <div class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onclick="toggleDropdown(this)">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>
                    <span class="nav-text">ESTIMATE</span>
                    <span class="dropdown-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </a>
                <div class="sidebar-dropdown">
                    {{-- <a href="" class="dropdown-item nav-link {{ Request::is('admin/emd*') ? 'active' : '' }}">ESTIMATION</a> --}}

                    <a href="{{ route('admin.schedule-work.index') }}" class="dropdown-item {{ Request::is('admin/schedule-work*') ? 'active' : '' }}">SCHEDULE MAKER</a>

                    {{-- <a href="{{ route('admin.projects.securityreturned.index') }}" class="dropdown-item {{ Request::is('admin/security*') ? 'active' : '' }}">ANALYSIS OF RATES</a> --}}

                </div>
            </div>

            {{-- <div class="nav-item">
                <a href="{{ route('admin.daily-notes.index') }}"
                class="nav-link {{ Request::is('admin/daily-notes*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">DAILY BOOK</span>
                </a>
            </div> --}}


        </nav>


    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="search-box">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Search campaigns, customers, or templates...">
            </div>
            <div>

                    <span style="color: red;" class="topbar-title text-center text-red">YOUR Project OverView P.O.V. TRIAL PERIOD IS VALID UPTO 31/03/2026</span>


            </div>
            <div class="topbar-actions">
                <button class="icon-btn" id="themeToggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
                    <svg id="darkIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg id="lightIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
                <button class="icon-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="notification-badge"></span>
                </button>
                <div class="user-profile">
                    <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 1)) }}

                    </div>
                    <span class="user-profile-text">{{ auth()->user()->name ?? 'Admin User' }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                        <style>
                            .logout-btn {
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0px;

                                    padding: 6px 10px;
                                    font-size: 10px;
                                    font-weight: 600;

                                    color: #000000;


                                    border: none;
                                    border-radius: 6px;
                                    cursor: pointer;

                                    transition: all 0.25s ease;

                                }

                                .logout-btn i {
                                    font-size: 10px;
                                }

                                /* Hover */
                                .logout-btn:hover {
                                    color: #ffffff;
                                    background: linear-gradient(135deg, #c82333, #9f1d2d);
                                    box-shadow: 0 6px 14px rgba(220, 53, 69, 0.35);
                                    transform: translateY(-1px);
                                }

                                /* Active (click) */
                                .logout-btn:active {
                                    transform: scale(0.97);
                                    box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
                                }

                                /* Focus (accessibility) */
                                .logout-btn:focus {
                                    outline: none;
                                    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.4);
                                }

                        </style>
                    </form>
                </div>

            </div>
        </header>

        <main class="content">
            <!-- Main Content -->
            <main class="main-content" id="mainContent">
                <div class="container-fluid">
                    @include('partials.alerts')
                    @yield('content')
                </div>
            </main>
        </main>
    </div>

    <script>
        // Theme Toggle
        let isDarkMode = true;

        function toggleTheme() {
            isDarkMode = !isDarkMode;
            const body = document.body;
            const darkIcon = document.getElementById('darkIcon');
            const lightIcon = document.getElementById('lightIcon');

            if (isDarkMode) {
                body.classList.remove('mode-light');
                body.classList.add('mode-dark');
                darkIcon.style.display = 'block';
                lightIcon.style.display = 'none';
            } else {
                body.classList.remove('mode-dark');
                body.classList.add('mode-light');
                darkIcon.style.display = 'none';
                lightIcon.style.display = 'block';
            }

            // Update chart colors
            updateChartColors();

            // Save preference
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        }

        // Load saved theme preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                toggleTheme();
            }
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');

            // Close all dropdowns when sidebar is collapsed
            if (document.getElementById('sidebar').classList.contains('collapsed')) {
                document.querySelectorAll('.nav-item.open').forEach(item => {
                    item.classList.remove('open');
                });
            }
        }

        function toggleDropdown(element) {
            const sidebar = document.getElementById('sidebar');

            // Don't open dropdown if sidebar is collapsed
            if (sidebar.classList.contains('collapsed')) {
                return;
            }

            const navItem = element.closest('.nav-item');
            const wasOpen = navItem.classList.contains('open');

            // Toggle current dropdown
            navItem.classList.toggle('open');
        }

        function toggleMobile() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        // Handle nav link clicks for routing
        document.querySelectorAll('.nav-link:not([onclick]), .dropdown-item').forEach(link => {
            link.addEventListener('click', function(e) {
                const route = this.getAttribute('data-route');

                // Remove active class from all links
                document.querySelectorAll('.nav-link, .dropdown-item').forEach(l => l.classList.remove('active'));

                // Add active class to clicked link
                this.classList.add('active');

                // If it's a dropdown item, also highlight parent
                if (this.classList.contains('dropdown-item')) {
                    const parentNavItem = this.closest('.nav-item');
                    if (parentNavItem) {
                        parentNavItem.querySelector('.nav-link').classList.add('active');
                    }
                }



                // Close mobile menu if open
                if (window.innerWidth <= 1024) {
                    toggleMobile();
                }
            });
        });

        // Close mobile menu when clicking dropdown items
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 1024) {
                    toggleMobile();
                }
            });
        });

        // Chart
        let chart;

        function initChart() {
            const ctx = document.getElementById('performanceChart').getContext('2d');

            const gradient1 = ctx.createLinearGradient(0, 0, 0, 280);
            gradient1.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
            gradient1.addColorStop(1, 'rgba(59, 130, 246, 0)');

            const gradient2 = ctx.createLinearGradient(0, 0, 0, 280);
            gradient2.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
            gradient2.addColorStop(1, 'rgba(16, 185, 129, 0)');

            const gradient3 = ctx.createLinearGradient(0, 0, 0, 280);
            gradient3.addColorStop(0, 'rgba(245, 158, 11, 0.3)');
            gradient3.addColorStop(1, 'rgba(245, 158, 11, 0)');

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Sent',
                        data: [2800, 2600, 5500, 3200, 4800, 3800, 3500, 4200, 5800, 8500, 5200, 7500],
                        borderColor: '#3b82f6',
                        backgroundColor: gradient1,
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#3b82f6',
                        pointHoverBackgroundColor: '#3b82f6',
                        pointBorderWidth: 2
                    }, {
                        label: 'Opened',
                        data: [2200, 2800, 9500, 3600, 4200, 3200, 3000, 3600, 4500, 9800, 6500, 5800],
                        borderColor: '#10b981',
                        backgroundColor: gradient2,
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#10b981',
                        pointHoverBackgroundColor: '#10b981',
                        pointBorderWidth: 2
                    }, {
                        label: 'Clicked',
                        data: [800, 900, 1800, 1200, 1600, 1300, 1100, 1500, 1700, 2100, 1900, 2200],
                        borderColor: '#f59e0b',
                        backgroundColor: gradient3,
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#f59e0b',
                        pointHoverBackgroundColor: '#f59e0b',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDarkMode ? '#1f2937' : '#ffffff',
                            titleColor: isDarkMode ? '#f9fafb' : '#111827',
                            bodyColor: isDarkMode ? '#9ca3af' : '#6b7280',
                            borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: true,
                            boxWidth: 8,
                            boxHeight: 8,
                            boxPadding: 4
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: isDarkMode ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.8)',
                                drawBorder: false
                            },
                            ticks: {
                                color: isDarkMode ? '#6b7280' : '#9ca3af',
                                font: {
                                    size: 11
                                },
                                padding: 8
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: isDarkMode ? '#6b7280' : '#9ca3af',
                                font: {
                                    size: 11
                                },
                                padding: 8
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function updateChartColors() {
            if (chart) {
                chart.options.plugins.tooltip.backgroundColor = isDarkMode ? '#1f2937' : '#ffffff';
                chart.options.plugins.tooltip.titleColor = isDarkMode ? '#f9fafb' : '#111827';
                chart.options.plugins.tooltip.bodyColor = isDarkMode ? '#9ca3af' : '#6b7280';
                chart.options.plugins.tooltip.borderColor = isDarkMode ? '#374151' : '#e5e7eb';
                chart.options.scales.y.grid.color = isDarkMode ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.8)';
                chart.options.scales.y.ticks.color = isDarkMode ? '#6b7280' : '#9ca3af';
                chart.options.scales.x.ticks.color = isDarkMode ? '#6b7280' : '#9ca3af';
                chart.update();
            }
        }

        // Initialize chart on page load
        initChart();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const toggleIcon = toggleBtn.querySelector('i');

        // Desktop toggle
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('expanded');

            if (sidebar.classList.contains('closed')) {
                toggleIcon.classList.remove('fa-angle-left');
                toggleIcon.classList.add('fa-angle-right');
            } else {
                toggleIcon.classList.remove('fa-angle-right');
                toggleIcon.classList.add('fa-angle-left');
            }
        });

        // Mobile toggle
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');

            if (sidebar.classList.contains('mobile-open')) {
                mobileToggle.querySelector('i').classList.remove('fa-bars');
                mobileToggle.querySelector('i').classList.add('fa-times');
            } else {
                mobileToggle.querySelector('i').classList.remove('fa-times');
                mobileToggle.querySelector('i').classList.add('fa-bars');
            }
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
            mobileToggle.querySelector('i').classList.remove('fa-times');
            mobileToggle.querySelector('i').classList.add('fa-bars');
        });

        // Close sidebar when clicking a link on mobile
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    mobileToggle.querySelector('i').classList.remove('fa-times');
                    mobileToggle.querySelector('i').classList.add('fa-bars');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                mobileToggle.querySelector('i').classList.remove('fa-times');
                mobileToggle.querySelector('i').classList.add('fa-bars');
            }
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>

<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.js"></script>

<script>
    new DataTable('#example', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,


        /* 🔥 GUARANTEED ROW COLOR FIX */
        createdRow: function (row, data, index) {
            let bg = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
            let base = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';

            $(row).off('mouseenter mouseleave').hover(
                () => $('td', row).css('background-color', '#e9ecff'),
                () => $('td', row).css('background-color', base)
            );
        }


    });


     new DataTable('.example', {
        scrollX: true,
        scrollCollapse: true,
        responsive: false,
        autoWidth: false,


        /* 🔥 GUARANTEED ROW COLOR FIX */
        createdRow: function (row, data, index) {
            let bg = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
            let base = (index % 2 === 0) ? '#f7f8ff' : '#ffffff';

            $(row).off('mouseenter mouseleave').hover(
                () => $('td', row).css('background-color', '#e9ecff'),
                () => $('td', row).css('background-color', base)
            );
        }


    });

</script>
    @stack('scripts')
</body>
</html>
