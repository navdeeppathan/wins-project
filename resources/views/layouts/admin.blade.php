<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
   <link rel="stylesheet" href="{{ asset('/style.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar-wrapper" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="brand-section">
                <div class="brand-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <span class="brand-text">ADMIN</span>
            </div>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-angle-left"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <div class="nav-section-title">Main Menu</div>
            
            <div class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('departments.index') }}" 
                class="nav-link {{ Request::is('departments*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="nav-text">Departments</span>
                </a>
            </div>


            <div class="nav-item">
                <a href="{{ route('admin.projects.index') }}" class="nav-link {{ Request::is('admin/projects*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <i class="fas fa-project-diagram"></i>
                    </span>
                    <span class="nav-text">Projects (Bidding)</span>
                    @if(isset($projectCount) && $projectCount > 0)
                        <span class="nav-badge">{{ $projectCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ Request::is('admin/vendors*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <i class="fas fa-users"></i>
                    </span>
                    <span class="nav-text">Vendors</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.inventory.index') }}" class="nav-link {{ Request::is('admin/inventory*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <i class="fas fa-boxes"></i>
                    </span>
                    <span class="nav-text">Inventory</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.tandp.index') }}" class="nav-link {{ Request::is('admin/tandp*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <i class="fas fa-tools"></i>
                    </span>
                    <span class="nav-text">T & P</span>
                </a>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 1)) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name ?? 'Admin User' }}</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="container-fluid">
            @include('partials.alerts')
            @yield('content')
        </div>
    </main>

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
    @stack('scripts')
</body>
</html>