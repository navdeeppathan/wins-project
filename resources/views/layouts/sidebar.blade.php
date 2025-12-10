<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }

        /* Sidebar Container */
        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #2d3561 0%, #1a1f3a 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Sidebar closed state */
        .sidebar-wrapper.closed {
            width: 80px;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #c76d8e 0%, #a85672 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 5px 15px rgba(199, 109, 142, 0.4);
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .brand-icon:hover {
            transform: scale(1.05);
        }

        .brand-text {
            color: white;
            font-size: 22px;
            font-weight: 700;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar-wrapper.closed .brand-text {
            opacity: 0;
            display: none;
        }

        .toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        /* Navigation Menu */
        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 10px;
            transition: opacity 0.3s;
        }

        .sidebar-wrapper.closed .nav-section-title {
            opacity: 0;
            display: none;
        }

        .nav-item {
            margin: 5px 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            gap: 15px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #c76d8e 0%, #a85672 100%);
            transform: scaleY(0);
            transition: transform 0.3s;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link:hover::before {
            transform: scaleY(1);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(199, 109, 142, 0.2) 0%, rgba(168, 86, 114, 0.2) 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(199, 109, 142, 0.2);
        }

        .nav-link.active::before {
            transform: scaleY(1);
        }

        .nav-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .nav-text {
            font-size: 15px;
            font-weight: 500;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar-wrapper.closed .nav-text {
            opacity: 0;
            display: none;
        }

        .sidebar-wrapper.closed .nav-link {
            justify-content: center;
            padding: 14px;
        }

        .nav-badge {
            background: linear-gradient(135deg, #c76d8e 0%, #a85672 100%);
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-left: auto;
            transition: opacity 0.3s;
        }

        .sidebar-wrapper.closed .nav-badge {
            opacity: 0;
            display: none;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #c76d8e 0%, #a85672 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            transition: opacity 0.3s;
        }

        .sidebar-wrapper.closed .user-info {
            opacity: 0;
            display: none;
        }

        .user-name {
            color: white;
            font-size: 14px;
            font-weight: 600;
            display: block;
            margin-bottom: 2px;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, #2d3561 0%, #1a1f3a 100%);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s;
        }

        .mobile-toggle:hover {
            transform: scale(1.05);
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(5px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                transform: translateX(-100%);
            }

            .sidebar-wrapper.mobile-open {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            .sidebar-wrapper {
                width: 260px;
            }

            .mobile-toggle {
                top: 15px;
                left: 15px;
            }

            .main-content {
                padding: 20px 15px;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-item {
            animation: slideIn 0.3s ease-out;
        }

        .nav-item:nth-child(1) { animation-delay: 0.05s; }
        .nav-item:nth-child(2) { animation-delay: 0.1s; }
        .nav-item:nth-child(3) { animation-delay: 0.15s; }
        .nav-item:nth-child(4) { animation-delay: 0.2s; }
        .nav-item:nth-child(5) { animation-delay: 0.25s; }
    </style>
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
                <a href="{{ url('/admin') }}" class="nav-link active">
                    <span class="nav-icon">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.projects.index') }}" class="nav-link">
                    <span class="nav-icon">
                        <i class="fas fa-project-diagram"></i>
                    </span>
                    <span class="nav-text">Projects (Bidding)</span>
                    <span class="nav-badge">5</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.vendors.index') }}" class="nav-link">
                    <span class="nav-icon">
                        <i class="fas fa-users"></i>
                    </span>
                    <span class="nav-text">Vendors</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.inventory.index') }}" class="nav-link">
                    <span class="nav-icon">
                        <i class="fas fa-boxes"></i>
                    </span>
                    <span class="nav-text">Inventory</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.tandp.index') }}" class="nav-link">
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
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <span class="user-name">Admin User</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="container-fluid">
            <h1 style="color: #2d3561; margin-bottom: 20px;">Welcome to Dashboard</h1>
            <div class="card border-0 shadow-sm" style="border-radius: 15px; padding: 30px;">
                <p style="color: #666; font-size: 16px; margin: 0;">
                    This is your main content area. The sidebar is fully responsive and features:
                </p>
                <ul style="color: #666; margin-top: 15px;">
                    <li>Collapsible desktop sidebar</li>
                    <li>Mobile-friendly drawer navigation</li>
                    <li>Active state indicators</li>
                    <li>Smooth animations and transitions</li>
                    <li>Badge notifications</li>
                    <li>User profile section</li>
                </ul>
            </div>
        </div>
    </main>

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
</body>
</html>