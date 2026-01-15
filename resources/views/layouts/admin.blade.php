<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiProject</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('/assets/admin.css') }}">

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
        @php
            $role = auth()->user()->role;

            $menu = [
                'dashboard'   => ['admin','staff'],
                'projects'    => ['admin','staff'],
                'acceptance'  => ['admin','staff'],
                'agreement'   => ['admin','staff'],
                'bill_of_quantity' => ['admin','staff'],
                'billing'     => ['admin'],
                'inventory'   => ['admin','staff'],
                'securities'  => ['admin'],
                'materials'   => ['admin'],
                'establishment'=> ['admin'],
                'estimate'    => ['admin','staff'],
            ];
        @endphp

        <div class="sidebar-header">
            {{-- <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div> --}}
            <span class="brand-name">
                <img src="{{asset('logo.jpeg')}}" alt="" style="height: 40px;   margin-right:10px;">

            </span>
            <button class="collapse-btn" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">

            @if(in_array($role, $menu['dashboard']))
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
            @endif



            @if(in_array($role, $menu['projects']))
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
            @endif

            @if(in_array($role, $menu['acceptance']))
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
            @endif

            @if(in_array($role, $menu['agreement']))
             <div class="nav-item">
                <a href="{{ route('admin.projects.award') }}"
                class="nav-link {{ Request::is('admin/award*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">PROJECTS (AGREEMENT)</span>
                </a>
            </div>
            @endif


            @if(in_array($role, $menu['bill_of_quantity']))
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
            @endif



            @if(in_array($role, $menu['billing']))
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
            @endif

            @if(in_array($role, $menu['inventory']))
            <div class="nav-item">
                <a href="{{ route('admin.inventory.tabindex') }}"
                class="nav-link {{ Request::is('admin/inventory*') ? 'active' : '' }}">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>

                    <span class="nav-text">INVENTORY</span>
                </a>
            </div>
            @endif


            @php
                $securitiesActive =
                    Request::is('admin/emd*') ||
                    Request::is('admin/pg*') ||
                    Request::is('admin/security*') ||
                    Request::is('admin/withheld*');
            @endphp

            @if(in_array($role, $menu['securities']))
            <div class="nav-item {{ $securitiesActive ? 'open' : '' }}">
                <a href="javascript:void(0)"
                class="nav-link {{ $securitiesActive ? 'active' : '' }}"
                onclick="toggleDropdown(this)">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>

                    <span class="nav-text">SECURITIES</span>

                    <span class="dropdown-arrow {{ $securitiesActive ? 'rotate' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </a>

                <div class="sidebar-dropdown" style="{{ $securitiesActive ? 'display:block;' : '' }}">
                    <a href="{{ route('admin.projects.returned.index') }}"
                    class="dropdown-item {{ Request::is('admin/emd*') ? 'active' : '' }}">
                        EMD
                    </a>

                    <a href="{{ route('admin.projects.pgreturned.index') }}"
                    class="dropdown-item {{ Request::is('admin/pg*') ? 'active' : '' }}">
                        PG
                    </a>

                    <a href="{{ route('admin.projects.securityreturned.index') }}"
                    class="dropdown-item {{ Request::is('admin/security*') ? 'active' : '' }}">
                        SECURITY DEPOSIT
                    </a>

                    <a href="{{ route('admin.projects.withheldreturned.index') }}"
                    class="dropdown-item {{ Request::is('admin/withheld*') ? 'active' : '' }}">
                        WITHHELD
                    </a>

                    <a href="{{ route('admin.projects.recoveries.tabindex') }}"
                    class="dropdown-item {{ Request::is('admin/allrecoveries*') ? 'active' : '' }}">
                        Recoveries
                    </a>
                </div>
            </div>
            @endif

            @if(in_array($role, $menu['materials']))
            <div class="nav-item">
                <a href="{{ route('admin.materialTabs.index') }}"
                    class="nav-link {{ Request::is('admin/materials*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>
                    <span class="nav-text">MATERIAL</span>
                </a>
            </div>
            @endif


            @php
                $establishmentActive =
                    Request::is('departments*') ||
                    Request::is('admin/vendors*') ||
                    Request::is('admin/users*') ||
                    Request::is('admin/cqc-vault*');
            @endphp

            @if(in_array($role, $menu['establishment']))
            <div class="nav-item {{ $establishmentActive ? 'open' : '' }}">
                <a href="javascript:void(0)"
                class="nav-link {{ $establishmentActive ? 'active' : '' }}"
                onclick="toggleDropdown(this)">

                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>

                    <span class="nav-text">ESTABLISHMENT</span>

                    <span class="dropdown-arrow {{ $establishmentActive ? 'rotate' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </a>

                <div class="sidebar-dropdown" style="{{ $establishmentActive ? 'display:block;' : '' }}">
                    <a href="{{ route('departments.index') }}"
                    class="dropdown-item {{ Request::is('departments*') ? 'active' : '' }}">
                        DEPARTMENTS
                    </a>

                    <a href="{{ route('admin.vendors.index') }}"
                    class="dropdown-item {{ Request::is('admin/vendors*') ? 'active' : '' }}">
                        VENDORS
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                    class="dropdown-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                        STAFF
                    </a>

                    <a href="{{ route('admin.cqc-vault.index') }}"
                    class="dropdown-item {{ Request::is('admin/cqc-vault*') ? 'active' : '' }}">
                        E-Vault
                    </a>
                </div>
            </div>
            @endif



            @if(in_array($role, $menu['estimate']))
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
            @endif




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

                    <span style="color: red;" class="topbar-title text-center text-red">YOUR DigiProject TRIAL PERIOD IS VALID UPTO 31/03/2026</span>


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

<script>
document.addEventListener('input', function (e) {
    const el = e.target;

    // Apply to ALL text inputs & textareas
    if (
        (el.tagName === 'INPUT' && el.type === 'text') ||
        el.tagName === 'TEXTAREA'
    ) {
        el.value = el.value.toUpperCase();
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('table input, table textarea').forEach(el => {

        // Skip unwanted input types
        const skipTypes = ['button', 'submit', 'reset', 'hidden', 'checkbox', 'radio', 'file'];
        if (el.tagName === 'INPUT' && skipTypes.includes(el.type)) return;
        if (el.hasAttribute('placeholder')) return;

        const td = el.closest('td');
        const tr = el.closest('tr');
        const table = el.closest('table');

        if (!td || !tr || !table) return;
        const colIndex = Array.from(tr.children).indexOf(td);
        const th = table.querySelector(`thead tr th:nth-child(${colIndex + 1})`);
        if (!th) return;

        let headerText = th.textContent.trim();
        headerText = headerText.replace(/[*:\n]/g, '').trim();

        if (headerText) {
            // First letter uppercase, rest lowercase
            const formattedText =
                headerText.charAt(0).toUpperCase() +
                headerText.slice(1).toLowerCase();

            el.setAttribute('placeholder', 'Enter ' + formattedText);
        }
    });

});
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
            let bg = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
             let base = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';

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
            let bg = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';
            $('td', row).css('background-color', bg);
        },

        rowCallback: function (row, data, index) {
             let base = (index % 2 === 0) ? '#D7E2F2' : '#B4C5E6';

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
