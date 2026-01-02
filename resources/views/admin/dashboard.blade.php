@extends('layouts.admin')

@section('title','Projects')

@section('content')

            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Welcome back! Here's an overview of your email marketing performance.</p>
            </div>

            <div class="action-cards">
                <div class="action-card">
                    <div class="action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3>New Campaign</h3>
                    <p>Create a new email campaign</p>
                </div>
                <div class="action-card">
                    <div class="action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3>Add Customers</h3>
                    <p>Import or add new contacts</p>
                </div>
                <div class="action-card">
                    <div class="action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                    </div>
                    <h3>Create Template</h3>
                    <p>Design a new email template</p>
                </div>
                <div class="action-card">
                    <div class="action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3>Setup Automation</h3>
                    <p>Build automated workflows</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="stat-change positive">↑ 12.5%</span>
                    </div>
                    <div class="stat-value">2,847</div>
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-meta">vs last month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="stat-change positive">↑ 8.2%</span>
                    </div>
                    <div class="stat-value">48.2K</div>
                    <div class="stat-label">Emails Sent</div>
                    <div class="stat-meta">vs last month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                        <span class="stat-change negative">↓ 2.4%</span>
                    </div>
                    <div class="stat-value">24.5%</div>
                    <div class="stat-label">Open Rate</div>
                    <div class="stat-meta">vs last month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                        </div>
                        <span class="stat-change positive">↑ 5.1%</span>
                    </div>
                    <div class="stat-value">3.8%</div>
                    <div class="stat-label">Click Rate</div>
                    <div class="stat-meta">vs last month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="stat-change positive">↑ 18.7%</span>
                    </div>
                    <div class="stat-value">1,248</div>
                    <div class="stat-label">Subscriptions</div>
                    <div class="stat-meta">vs last month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="stat-change positive">↑ 22.3%</span>
                    </div>
                    <div class="stat-value">$12.4K</div>
                    <div class="stat-label">Revenue</div>
                    <div class="stat-meta">vs last month</div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">
                        <div class="chart-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="chart-title-text">
                            <h3>Email Performance</h3>
                            <p>Monthly email statistics</p>
                        </div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="legend-dot" style="background: #3b82f6;"></span>
                            <span>Sent</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background: #10b981;"></span>
                            <span>Opened</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background: #f59e0b;"></span>
                            <span>Clicked</span>
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>

@endsection            

            