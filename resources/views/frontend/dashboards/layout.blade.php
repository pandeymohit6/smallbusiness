@extends('frontend.layouts.app')

@section('content')
    <div id="container">
        <div class="wrap">
            <div class="col-md-2 dashboard-sidebar" x-data="{ sellerOpen: true, buyerOpen: false }">

                <div class="sidebar-header p-3">
                    <h5>Your Accounts</h5>
                </div>

                <!-- Seller -->
                <div>
                    <div class="menu-header" @click="sellerOpen=!sellerOpen">
                        <span>🏪 Private Seller</span>
                        <span x-text="sellerOpen ? '−' : '+'"></span>
                    </div>

                    <div x-show="sellerOpen" x-transition class="menu-content">
                        <a href="{{ route('seller.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('seller.resources') }}"
                            class="sidebar-link {{ request()->routeIs('seller.resources') ? 'active' : '' }}">
                            Resources
                        </a>

                        <a href="{{ route('seller.value-business') }}"
                            class="sidebar-link {{ request()->routeIs('seller.value-business') ? 'active' : '' }}">
                            Value My Business
                        </a>
                    </div>
                </div>

                <!-- Buyer -->
                <div>
                    <div class="menu-header" @click="buyerOpen=!buyerOpen">
                        <span>🛒 Buyer</span>
                        <span x-text="buyerOpen ? '−' : '+'"></span>
                    </div>

                    <div x-show="buyerOpen" x-transition class="menu-content">
                        <a href="{{ route('buyer.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('buyer.sent-inquiries') }}"
                            class="sidebar-link {{ request()->routeIs('buyer.sent-inquiries') ? 'active' : '' }}">
                            Sent Inquiries
                        </a>

                        <a href="{{ route('buyer.saved-searches') }}"
                            class="sidebar-link {{ request()->routeIs('buyer.saved-searches') ? 'active' : '' }}">
                            Saved Searches
                        </a>

                        <a href="{{ route('buyer.shortlist') }}"
                            class="sidebar-link {{ request()->routeIs('buyer.shortlist') ? 'active' : '' }}">
                            Shortlist
                        </a>
                    </div>
                </div>

                <!-- Settings -->
                <div class="mt-3">

                    <a href="{{ route('seller.settings') }}" class="sidebar-link">
                        Account Settings
                    </a>
                </div>

                <!-- Logout -->
                <div class="mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-link logout-btn border-0 bg-transparent w-100 text-start">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <style>
        #container {
            width: 100%;
            clear: both;
            min-height: 50vh;
        }

        .wrap {
            width: 1300px;
            max-width: 100%;
            margin: 0 auto;
            position: relative;
        }

        /* Sidebar */
        .dashboard-sidebar {
            background: #0b2e59;
            color: #fff;
            padding: 0;
            min-height: 50vh;
        }

        .sidebar-header {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h5,
        .dashboard-sidebar .section-title {
            color: #fff;
            font-weight: 600;
        }

        /* Menu Lists */
        .nav-menus {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Bootstrap Navigation Links */
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            margin: 4px 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .nav-link.active {
            background: #fff;
            color: #0d47a1 !important;
            font-weight: 600;
        }

        /* Custom Sidebar Links */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #dbeafe;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: #174a8b;
            color: #fff;
        }

        .sidebar-link.active {
            color: #00B4D8 !important;
            border-left: 4px solid #fff;
        }

        /* Dropdown Headers */
        .menu-header,
        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .menu-toggle:hover,
        .menu-header:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .menu-content {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Main Content */
        .dashboard-content {
            background: #f8fafc;
            min-height: 50vh;
        }

        /* Logout */
        .logout-btn {
            color: #fff !important;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
