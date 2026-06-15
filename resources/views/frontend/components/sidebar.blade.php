<div class="dashboard-sidebar" x-data="{
    activeMenu: '{{ request()->routeIs('buyer.*') ? 'buyer' : (request()->routeIs('*.settings') || request()->routeIs('*.profile') ? 'settings' : 'seller') }}'
}">

    <div class="sidebar-header p-3">
        <h5>Your Accounts</h5>
    </div>

    <!-- Seller -->
    <div>
        <div class="menu-header" @click="activeMenu = activeMenu === 'seller' ? '' : 'seller'">
            <span>🏪 Private Seller</span>
            <span x-text="activeMenu === 'seller' ? '−' : '+'"></span>
        </div>

        <div x-show="activeMenu === 'seller'" x-transition class="menu-content">

            @if ($sellersMenu && $sellersMenu->items->count())
                @foreach ($sellersMenu->items->whereNull('parent_id') as $menuItem)
                    <a href="{{ $menuItem->getUrl() }}" @if ($menuItem->target_blank) target="_blank" @endif
                        class="sidebar-link {{ request()->routeIs($menuItem->target) ? 'active' : '' }}">{{ $menuItem->label }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Buyer -->
    <div>
        <div class="menu-header" @click="activeMenu = activeMenu === 'buyer' ? '' : 'buyer'">
            <span>🛒 Buyer</span>
            <span x-text="activeMenu === 'buyer' ? '−' : '+'"></span>
        </div>

        <div x-show="activeMenu === 'buyer'" x-transition class="menu-content">
            @if ($buyersMenu && $buyersMenu->items->count())
                @foreach ($buyersMenu->items->whereNull('parent_id') as $menuItem)
                        <a href="{{ $menuItem->getUrl() }}" @if ($menuItem->target_blank) target="_blank" @endif
                            class="sidebar-link {{ request()->routeIs($menuItem->target) ? 'active' : '' }}">{{ $menuItem->label }}
                        </a>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Settings -->
    <div>
        <div class="menu-header" @click="activeMenu = activeMenu === 'settings' ? '' : 'settings'">
            <span>⚙️ Account Settings</span>
            <span x-text="activeMenu === 'settings' ? '−' : '+'"></span>
        </div>

        <div x-show="activeMenu === 'settings'" x-transition class="menu-content">
            <a href="{{ route('seller.settings') }}" class="sidebar-link">
                General Settings
            </a>

            <a href="{{ route('seller.profile') }}" class="sidebar-link">
                Profile Settings
            </a>

            <a href="#" class="sidebar-link">
                Notification Settings
            </a>

            <a href="#" class="sidebar-link">
                Change Password
            </a>
        </div>
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
