<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    <div class="header-wrapper_1">
        <div class="top-bar">
            <div class="container top_mob">
                <a href="#" class="logo-desktop">
                    SmallBusinessesForSale.com<span class="stars">★</span>
                </a>
                <a href="#" class="orange-cta">Sell Your Business</a>
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
                                                <a href="{{ $child->url ?? '#' }}"
                                                    @if ($child->target) target="{{ $child->target }}" @endif>
                                                    {{ $child->label }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ $menuItem->url ?? '#' }}" class="nav-link"
                                        @if ($menuItem->target) target="{{ $menuItem->target }}" @endif>
                                        {{ $menuItem->label }}
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    @endif
                </ul>

                <div class="right-meta">
                    <!-- Country Selector Dropdown -->
                    <div class="country-selector-wrapper" style="position: relative; display: inline-block;">
                        <button class="country-selector-btn" style="background: none; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 5px; padding: 8px;">
                            <span>🌐</span>
                            <span class="current-country">
                                @if($currentCountry && isset($availableCountries[$currentCountry]))
                                    {{ $availableCountries[$currentCountry] }}
                                @else
                                    Global
                                @endif
                            </span>
                            <span style="font-size: 12px;">▼</span>
                        </button>
                        
                        <!-- Country Dropdown Menu -->
                        <div class="country-dropdown-menu" style="display: none; position: absolute; top: 100%; left: 0; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); min-width: 250px; z-index: 1000;">
                            <!-- Current Country - Stay Here -->
                            <div style="padding: 10px 15px; border-bottom: 1px solid #eee;">
                                <strong style="color: #333;">Stay here</strong>
                                @if($currentCountry)
                                    <div style="color: #666; font-size: 13px; margin-top: 5px;">
                                        @if(isset($availableCountries[$currentCountry]))
                                            {{ $availableCountries[$currentCountry] }}
                                        @else
                                            {{ $currentCountry }}
                                        @endif
                                    </div>
                                @else
                                    <div style="color: #666; font-size: 13px; margin-top: 5px;">
                                        <a href="{{ request()->getHost() }}/" style="color: #0066cc; text-decoration: none;">
                                            Stay on {{ request()->getHost() }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Change Country -->
                            <div style="padding: 10px 15px;">
                                <strong style="color: #333; display: block; margin-bottom: 10px;">Change to</strong>
                                @forelse($availableCountries ?? [] as $code => $countryName)
                                    @php
                                        $countryCode = strtolower($code);
                                        $subdomain = ($code === 'US') ? 'www' : $countryCode;
                                        $baseHost = str_replace(['www.', $countryCode . '.'], '', request()->getHost());
                                        $newUrl = "https://{$subdomain}.{$baseHost}/";
                                    @endphp
                                    <div style="padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                        <a href="{{ $newUrl }}" style="color: #0066cc; text-decoration: none; display: flex; justify-content: space-between; align-items: center;">
                                            <span>{{ $countryName }}</span>
                                            <span style="font-size: 12px; color: #999;">{{ $baseHost }}</span>
                                        </a>
                                    </div>
                                @empty
                                    <div style="padding: 8px 0; color: #999; text-align: center;">
                                        No other countries available
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <a href="#" class="login-link">Login</a>
                </div>
            </div>

            <div class="mobile-header">
                <a href="#" class="logo-mobile">
                    BFS<span class="stars">★</span>
                </a>

                <div class="mobile-actions">
                    <!-- Mobile Country Selector -->
                    <div class="mobile-country-selector" style="position: relative; display: inline-block;">
                        <button class="country-selector-btn" style="background: none; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 5px; padding: 8px; font-size: 12px;">
                            <span>🌐</span>
                            <span style="max-width: 60px; overflow: hidden; text-overflow: ellipsis;">
                                @if($currentCountry && isset($availableCountries[$currentCountry]))
                                    {{ substr($availableCountries[$currentCountry], 0, 3) }}
                                @else
                                    Global
                                @endif
                            </span>
                        </button>
                        
                        <!-- Mobile Country Dropdown -->
                        <div class="country-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000;">
                            <div style="padding: 10px 15px; border-bottom: 1px solid #eee;">
                                <strong style="color: #333; font-size: 12px;">Stay here</strong>
                            </div>
                            <div style="padding: 10px 15px; max-height: 250px; overflow-y: auto;">
                                @forelse($availableCountries ?? [] as $code => $countryName)
                                    @php
                                        $countryCode = strtolower($code);
                                        $subdomain = ($code === 'US') ? 'www' : $countryCode;
                                        $baseHost = str_replace(['www.', $countryCode . '.'], '', request()->getHost());
                                        $newUrl = "https://{$subdomain}.{$baseHost}/";
                                    @endphp
                                    <div style="padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                        <a href="{{ $newUrl }}" style="color: #0066cc; text-decoration: none; font-size: 12px; display: block;">
                                            {{ $countryName }}
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
                @if ($headerMenu && $headerMenu->items->count() > 0)
                    @foreach ($headerMenu->items as $menuItem)
                        @if ($menuItem->children->count() > 0)
                            <li class="nav-item">
                                <span class="nav-link">{{ $menuItem->label }} <span class="arrow-down"></span></span>
                                <ul class="dropdown-menu">
                                    @foreach ($menuItem->children as $child)
                                        <li><a href="{{ $child->url ?? '#' }}"
                                                {{ $child->target ? "target=\"{$child->target}\"" : '' }}>{{ $child->label }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ $menuItem->url ?? '#' }}" class="nav-link"
                                    {{ $menuItem->target ? "target=\"{$menuItem->target}\"" : '' }}>{{ $menuItem->label }}</a>
                            </li>
                        @endif
                    @endforeach
                @else
                    <!-- Fallback static menu -->
                    <li class="nav-item active"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item">
                        <span class="nav-link">Businesses <span class="arrow-down"></span></span>
                        <ul class="dropdown-menu">
                            <li><a href="#">Search Businesses</a></li>
                            <li><a href="#">Buy a Business</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">Franchises <span class="arrow-down"></span></span>
                        <ul class="dropdown-menu">
                            <li><a href="#">Search Franchises</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">Selling <span class="arrow-down"></span></span>
                        <ul class="dropdown-menu">
                            <li><a href="#">Sell Your Business</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">Valuation</a></li>
                    <li class="nav-item">
                        <span class="nav-link">Resources <span class="arrow-down"></span></span>
                        <ul class="dropdown-menu">
                            <li><a href="#">Latest Guides</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <a href="#" class="mobile-login-btn">🔒 Login / Sign In</a>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countryBtn = document.querySelector('.country-selector-btn');
    const countryMenu = document.querySelector('.country-dropdown-menu');
    
    if (countryBtn && countryMenu) {
        // Toggle dropdown on button click
        countryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            countryMenu.style.display = countryMenu.style.display === 'none' ? 'block' : 'none';
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.country-selector-wrapper')) {
                countryMenu.style.display = 'none';
            }
        });
        
        // Close dropdown when a country link is clicked
        const countryLinks = countryMenu.querySelectorAll('a');
        countryLinks.forEach(link => {
            link.addEventListener('click', function() {
                countryMenu.style.display = 'none';
            });
        });
    }
});
</script>
