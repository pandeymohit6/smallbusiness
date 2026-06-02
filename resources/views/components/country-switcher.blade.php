<!-- Country Switcher Component -->
<div class="country-switcher">
    @if (is_viewing_all_countries())
        <span class="badge badge-info">Viewing All Countries</span>
    @else
        <span class="badge badge-primary">{{ current_country()?->label() }}</span>
    @endif

    <div class="country-links">
        <!-- Main/All Countries Link -->
        <a href="{{ all_countries_url() }}" 
           class="btn btn-sm {{ is_viewing_all_countries() ? 'btn-primary' : 'btn-outline-primary' }}">
            View All
        </a>

        <!-- Country-specific Links -->
        @foreach (get_all_countries() as $country)
            <a href="{{ country_url($country) }}" 
               class="btn btn-sm {{ is_country($country) ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ $country->label() }}
            </a>
        @endforeach
    </div>
</div>

<style>
.country-switcher {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.country-links {
    display: flex;
    gap: 0.5rem;
}
</style>
