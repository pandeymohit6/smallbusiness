<div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    <div class="header-wrapper_1">
        <div class="top-bar">
            <div class="container top_mob">
                <a href="{{ route('home') }}" class="logo-desktop">
                    SmallBusinessesForSale.com<span class="stars">★</span>
                </a>
                <a href="{{ $hasCountrySubdomain ? route('sell.business.country', ['code' => $countryCode]) : route('sell.business') }}"
                    class="orange-cta">
                    Sell Your Business
                </a>
            </div>
        </div>
        <div class="container">
            <div class="bottom-bar">
                <ul class="nav-menus">
                    @if ($headerMenu && $headerMenu->items->count())

                        @foreach ($headerMenu->items->whereNull('parent_id') as $menuItem)
                            @if ($menuItem->children && $menuItem->children->count())
                                <li class="nav-item dropdown">
                                    <span class="nav-link">
                                        {{ $menuItem->label }}
                                        <span class="arrow-down"></span>
                                    </span>

                                    <ul class="dropdown-menu">
                                        @foreach ($menuItem->children as $child)
                                            <li>
                                                <a href="{{ $child->getUrl() ?? '#' }}"
                                                    @if ($child->target_blank) target="{{ $child->target_blank }}" @endif>
                                                    {{ $child->label }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ $menuItem->getUrl() ?? '#' }}" class="nav-link"
                                        @if ($menuItem->target_blank) target="{{ $menuItem->target_blank }}" @endif>
                                        {{ $menuItem->label }}
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    @endif
                </ul>

                <div class="right-meta">
                    <!-- Country Selector Dropdown -->
                    <div class="country-selector-wrapper" x-data="{ open: false }" @click.outside="open = false"
                        style="position: relative; display: inline-block;">

                        <button type="button" class="country-selector-btn" @click="open = !open"
                            style="background:none;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;gap:5px;padding:8px;font-size:12px;">
                            <span>🌐</span>

                            <span class="current-country">
                                @php
                                    $country = collect($availableCountries)->firstWhere(
                                        'slug',
                                        $countryCode,
                                    );
                                @endphp

                                <span class="current-country">
                                    {{ $country->name ?? 'INT' }}
                                </span>
                            <span style="font-size:12px;">▼</span>
                        </button>

                        <div x-show="open" x-transition
                            style="display:none; position:absolute; top:100%; right:0; background:white; border:1px solid #ddd; border-radius:4px; box-shadow:0 2px 10px rgba(0,0,0,.1); min-width:200px; z-index:1000;">

                            <div style="padding:10px 15px; border-bottom:1px solid #eee;">
                                <strong style="color:#333;">Stay here</strong>

                                <div style="color:#666;font-size:13px;margin-top:5px;">
                                    {{ request()->getHost() }}
                                </div>
                            </div>

                            <div style="padding:10px 15px;">
                                <strong style="color:#333;display:block;margin-bottom:10px;">
                                    Change to
                                </strong>

                                @forelse($availableCountries ?? [] as $code => $country)
                                    @php
                                        $host = request()->getHost();
                                        $port = request()->getPort();
                                        $scheme = request()->getScheme();

                                        $countrySubdomain = strtolower($country->slug);

                                        if (str_contains($host, 'localhost')) {
                                            $newUrl = "{$scheme}://{$countrySubdomain}.localhost:{$port}";
                                        } else {
                                            $parts = explode('.', $host);
                                            if (count($parts) > 2) {
                                                array_shift($parts);
                                            }

                                            $rootDomain = implode('.', $parts);

                                            $newUrl = "{$scheme}://{$countrySubdomain}.{$rootDomain}:{$port}";
                                        }
                                    @endphp
                                    <div style="padding:8px 0;border-bottom:1px solid #f0f0f0;">
                                        <a href="{{ $newUrl }}"
                                            style="color:#0066cc;text-decoration:none;display:flex;justify-content:space-between;">
                                            <i class="flag flag-china"></i><span>{{ $country->name }}</span>
                                          
                                        </a>
                                    </div>
                                @empty
                                    <div style="padding:8px 0;color:#999;text-align:center;">
                                        No other countries available
                                    </div>
                                @endforelse

                            </div>

                        </div>

                    </div>

                    <!-- User Menu or Login Link -->
                    @auth
                        <div class="user-menu-wrapper" x-data="{ open: false }" @click.outside="open = false"
                            style="position: relative; display: inline-block; margin-left: 20px;">
                            
                            <button type="button" class="user-menu-btn" @click="open = !open"
                                style="background: none; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 6px; transition: background 0.3s ease;">
                                <span style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                    {{ substr(auth()->user()->first_name ?? auth()->user()->email, 0, 1) }}
                                </span>
                                <span style="font-size: 12px; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ auth()->user()->first_name ?? auth()->user()->email }}
                                </span>
                                <span style="font-size: 10px;">▼</span>
                            </button>

                            <div x-show="open" x-transition
                                style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 250px; z-index: 1000; margin-top: 8px;">
                                
                                <div style="padding: 15px; border-bottom: 1px solid #eee;">
                                    <div style="font-size: 12px; color: #666; margin-bottom: 5px;">Logged in as</div>
                                    <div style="font-weight: 600; color: #333; word-break: break-word;">
                                        {{ auth()->user()->email }}
                                    </div>
                                    <div style="font-size: 12px; color: #999; margin-top: 5px;">
                                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                    </div>
                                </div>

                                <div style="padding: 10px 0;">
                                    <a href="{{ route('profile.edit') }}" 
                                        style="display: block; padding: 12px 15px; color: #333; text-decoration: none; font-size: 14px; transition: background 0.2s ease;"
                                        onmouseover="this.style.background='#f5f5f5'"
                                        onmouseout="this.style.background='transparent'">
                                        <i style="margin-right: 8px;">👤</i> My Profile
                                    </a>
                                    <a href="" 
                                        style="display: block; padding: 12px 15px; color: #333; text-decoration: none; font-size: 14px; transition: background 0.2s ease;"
                                        onmouseover="this.style.background='#f5f5f5'"
                                        onmouseout="this.style.background='transparent'">
                                        <i style="margin-right: 8px;">📊</i> Dashboard
                                    </a>
                                </div>

                                <div style="border-top: 1px solid #eee;">
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" 
                                            style="width: 100%; text-align: left; padding: 12px 15px; color: #dc2626; background: none; border: none; cursor: pointer; font-size: 14px; transition: background 0.2s ease; font-weight: 600;"
                                            onmouseover="this.style.background='#fee2e2'"
                                            onmouseout="this.style.background='transparent'">
                                            <i style="margin-right: 8px;">🚪</i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="login-link">Login</a>
                    @endauth
                </div>
            </div>

            <div class="mobile-header">
                <a href="#" class="logo-mobile">
                    BFS<span class="stars">★</span>
                </a>

                <div class="mobile-actions">
                    <!-- Mobile Country Selector -->
                    <div class="mobile-country-selector" x-data="{ open: false }" @click.outside="open = false"
                        style="position: relative; display: inline-block;">
                        <button class="country-selector-btn"
                            style="background:none;border:none;color:#fff;cursor:pointer;display:flex;align-items:center;gap:5px;padding:8px;font-size:12px;">

                            <span>🌐</span>

                            <span style="max-width:60px;overflow:hidden;text-overflow:ellipsis;">
                                @php
                                    $country = collect($availableCountries)->firstWhere(
                                        'slug',
                                        $countryCode,
                                    );
                                @endphp

                                <span class="current-country">
                                    {{ $country->name ?? 'Global' }}
                                </span>
                            </span>

                        </button>

                        <!-- Mobile Country Dropdown -->
                        <div class="country-dropdown-menu"
                            style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000;">
                            <div style="padding: 10px 15px; border-bottom: 1px solid #eee;">
                                <strong style="color: #333; font-size: 12px;">Stay here</strong>
                            </div>
                            <div style="padding: 10px 15px; max-height: 250px; overflow-y: auto;">
                                @forelse($availableCountries ?? [] as $code => $country)
                                    @php
                                        $host = request()->getHost();
                                        $port = request()->getPort();
                                        $scheme = request()->getScheme();

                                        $countrySubdomain = strtolower($country->slug);

                                        if (str_contains($host, 'localhost')) {
                                            $newUrl = "{$scheme}://{$countrySubdomain}.localhost:{$port}";
                                        } else {
                                            $parts = explode('.', $host);
                                            if (count($parts) > 2) {
                                                array_shift($parts);
                                            }

                                            $rootDomain = implode('.', $parts);

                                            $newUrl = "{$scheme}://{$countrySubdomain}.{$rootDomain}:{$port}";
                                        }
                                    @endphp
                                    <div style="padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                        <a href="{{ $newUrl }}"
                                            style="color: #0066cc; text-decoration: none; font-size: 12px; display: block;">
                                            <i class="flag flag-china"></i> {{ $country->name }}
                                        </a>
                                    </div>
                                @empty
                                    <div style="padding: 8px 0; color: #999; text-align: center; font-size: 12px;">
                                        No other countries
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <a href="#" class="orange-cta" style="padding: 7px 14px; font-size: 13px;">Sell now</a>

                    <div class="menu-toggle" id="mob-hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="mobile-drawer" id="mob-drawer-container">
            <ul class="nav-menu">
                @if ($headerMenu && $headerMenu->items->count())

                        @foreach ($headerMenu->items->whereNull('parent_id') as $menuItem)
                        @if ($menuItem->children->count() > 0)
                            <li class="nav-item">
                                <span class="nav-link">{{ $menuItem->label }} <span class="arrow-down"></span></span>
                                <ul class="dropdown-menu">
                                    @foreach ($menuItem->children as $child)
                                        <li><a href="{{ $child->target ?? '#' }}"
                                                {{ $child->target_blank ? "target=\"{$child->target_blank}\"" : '' }}>{{ $child->label }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ $menuItem->target ?? '#' }}" class="nav-link"
                                    {{ $menuItem->target_blank ? "target=\"{$menuItem->target_blank}\"" : '' }}>{{ $menuItem->label }}</a>
                            </li>
                        @endif
                    @endforeach

                @endif
            </ul>
            @auth
                <div style="padding: 15px; border-top: 1px solid #eee; margin-top: 10px;">
                    <div style="font-size: 12px; color: #666; margin-bottom: 8px;">Logged in as</div>
                    <div style="font-weight: 600; color: #333; margin-bottom: 12px; word-break: break-word;">
                        {{ auth()->user()->email }}
                    </div>
                    <a href="{{ route('profile.edit') }}" style="display: block; padding: 10px; color: #0066cc; text-decoration: none; font-size: 13px; margin-bottom: 8px; border: 1px solid #e0e0e0; border-radius: 4px; text-align: center;">
                        👤 My Profile
                    </a>
                    <a href="{{ route('home') }}" style="display: block; padding: 10px; color: #0066cc; text-decoration: none; font-size: 13px; margin-bottom: 8px; border: 1px solid #e0e0e0; border-radius: 4px; text-align: center;">
                        📊 Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: block;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 10px; color: #dc2626; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 4px; font-size: 13px; font-weight: 600; cursor: pointer;">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="mobile-login-btn">🔒 Login / Sign In</a>
            @endauth
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
