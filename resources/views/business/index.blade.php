@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ __('Businesses for Sale') }}</h1>
            <p class="text-muted mb-0">{{ __('Browse active listings and send enquiries to sellers.') }}</p>
        </div>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('Search by title or location') }}">
        </div>
        <div class="col-md-3">
            <select name="country" class="form-select" onchange="updateStates()">
                <option value="">{{ __('All Countries') }}</option>
                @foreach(get_location_countries() as $value => $label)
                    <option value="{{ $value }}" @selected(request('country') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select id="state-filter" name="state" class="form-select" onchange="updateCities()">
                <option value="">{{ __('All States') }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="city-filter" name="city" class="form-select">
                <option value="">{{ __('All Cities') }}</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">{{ __('All Types') }}</option>
                @foreach(\App\Models\Business::getBusinessTypes() as $value => $label)
                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="industry" class="form-select">
                <option value="">{{ __('All Industries') }}</option>
                @foreach(\App\Models\Business::getIndustries() as $value => $label)
                    <option value="{{ $value }}" @selected(request('industry') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">{{ __('Filter') }}</button>
        </div>
    </form>

    <div class="row g-4">
        @forelse($businesses as $business)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h5">{{ $business->title }}</h2>
                        <p class="text-muted small mb-2">{{ format_location($business->country_code, $business->state, $business->city) }} · {{ \App\Models\Business::getIndustries()[$business->industry] ?? $business->industry }}</p>
                        <p>{{ \Illuminate\Support\Str::limit($business->description, 140) }}</p>
                        <div class="fw-semibold mb-3">{{ number_format((float) $business->asking_price, 2) }}</div>
                        <a class="btn btn-outline-primary" href="{{ route('businesses.show', $business->slug) }}">{{ __('View Details') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">{{ __('No active listings found.') }}</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $businesses->links() }}</div>
</div>

<script>
const statesData = {
    'United States': {
        'AL': 'Alabama', 'AK': 'Alaska', 'AZ': 'Arizona', 'AR': 'Arkansas',
        'CA': 'California', 'CO': 'Colorado', 'CT': 'Connecticut', 'DE': 'Delaware',
        'FL': 'Florida', 'GA': 'Georgia', 'HI': 'Hawaii', 'ID': 'Idaho',
        'IL': 'Illinois', 'IN': 'Indiana', 'IA': 'Iowa', 'KS': 'Kansas',
        'KY': 'Kentucky', 'LA': 'Louisiana', 'ME': 'Maine', 'MD': 'Maryland',
        'MA': 'Massachusetts', 'MI': 'Michigan', 'MN': 'Minnesota', 'MS': 'Mississippi',
        'MO': 'Missouri', 'MT': 'Montana', 'NE': 'Nebraska', 'NV': 'Nevada',
        'NH': 'New Hampshire', 'NJ': 'New Jersey', 'NM': 'New Mexico', 'NY': 'New York',
        'NC': 'North Carolina', 'ND': 'North Dakota', 'OH': 'Ohio', 'OK': 'Oklahoma',
        'OR': 'Oregon', 'PA': 'Pennsylvania', 'RI': 'Rhode Island', 'SC': 'South Carolina',
        'SD': 'South Dakota', 'TN': 'Tennessee', 'TX': 'Texas', 'UT': 'Utah',
        'VT': 'Vermont', 'VA': 'Virginia', 'WA': 'Washington', 'WV': 'West Virginia',
        'WI': 'Wisconsin', 'WY': 'Wyoming', 'DC': 'District of Columbia'
    },
    'Canada': {
        'AB': 'Alberta', 'BC': 'British Columbia', 'MB': 'Manitoba',
        'NB': 'New Brunswick', 'NL': 'Newfoundland and Labrador', 'NS': 'Nova Scotia',
        'NT': 'Northwest Territories', 'NU': 'Nunavut', 'ON': 'Ontario',
        'PE': 'Prince Edward Island', 'QC': 'Quebec', 'SK': 'Saskatchewan',
        'YT': 'Yukon'
    },
    'Australia': {
        'NSW': 'New South Wales', 'QLD': 'Queensland', 'SA': 'South Australia',
        'TAS': 'Tasmania', 'VIC': 'Victoria', 'WA': 'Western Australia',
        'ACT': 'Australian Capital Territory', 'NT': 'Northern Territory'
    }
};

const citiesData = {
    'United States': {
        'CA': ['Los Angeles', 'San Francisco', 'San Diego', 'Sacramento', 'San Jose', 'Fresno', 'Long Beach'],
        'NY': ['New York', 'Buffalo', 'Rochester', 'Yonkers', 'Albany', 'New Rochelle', 'Syracuse'],
        'TX': ['Houston', 'Dallas', 'Austin', 'San Antonio', 'Fort Worth', 'Phoenix', 'San Diego'],
        'FL': ['Miami', 'Orlando', 'Tampa', 'Jacksonville', 'Fort Lauderdale', 'Tallahassee', 'St. Petersburg'],
        'IL': ['Chicago', 'Aurora', 'Rockford', 'Joliet', 'Naperville', 'Peoria', 'Elgin'],
        'PA': ['Philadelphia', 'Pittsburgh', 'Allentown', 'Erie', 'Reading', 'Scranton', 'Bethlehem'],
        'OH': ['Columbus', 'Cleveland', 'Cincinnati', 'Toledo', 'Akron', 'Dayton', 'Parma'],
        'GA': ['Atlanta', 'Augusta', 'Columbus', 'Savannah', 'Athens', 'Macon', 'Roswell'],
        'NC': ['Charlotte', 'Raleigh', 'Greensboro', 'Durham', 'Winston-Salem', 'Fayetteville', 'Cary'],
        'MI': ['Detroit', 'Grand Rapids', 'Warren', 'Sterling Heights', 'Ann Arbor', 'Lansing', 'Flint']
    },
    'Canada': {
        'ON': ['Toronto', 'Ottawa', 'Hamilton', 'London', 'Kitchener', 'Brampton', 'Mississauga'],
        'QC': ['Montreal', 'Quebec City', 'Laval', 'Gatineau', 'Longueuil', 'Sherbrooke', 'Trois-Rivières'],
        'BC': ['Vancouver', 'Victoria', 'Surrey', 'Burnaby', 'Coquitlam', 'Abbotsford', 'Langley'],
        'AB': ['Calgary', 'Edmonton', 'Red Deer', 'Lethbridge', 'Medicine Hat', 'Fort McMurray', 'Airdrie'],
        'MB': ['Winnipeg', 'Brandon', 'Flin Flon', 'Selkirk', 'Thompson', 'Portage la Prairie', 'Dauphin'],
        'SK': ['Regina', 'Saskatoon', 'Prince Albert', 'Moose Jaw', 'Yorkton', 'Swift Current', 'Lloydminster'],
        'NS': ['Halifax', 'Sydney', 'Cape Breton', 'Glace Bay', 'New Waterford', 'Truro', 'New Glasgow'],
        'NB': ['Saint John', 'Fredericton', 'Moncton', 'Saint-Jean', 'Bathurst', 'Campbellton', 'Miramichi']
    },
    'Australia': {
        'NSW': ['Sydney', 'Newcastle', 'Wollongong', 'Central Coast', 'Lismore', 'Coffs Harbour', 'Tamworth'],
        'VIC': ['Melbourne', 'Geelong', 'Ballarat', 'Bendigo', 'Echuca', 'Shepparton', 'Traralgon'],
        'QLD': ['Brisbane', 'Gold Coast', 'Sunshine Coast', 'Cairns', 'Townsville', 'Rockhampton', 'Toowoomba'],
        'WA': ['Perth', 'Fremantle', 'Mandurah', 'Bunbury', 'Geraldton', 'Albany', 'Kalgoorlie'],
        'SA': ['Adelaide', 'Mount Gambier', 'Victor Harbor', 'Port Augusta', 'Port Pirie', 'Ceduna', 'Whyalla'],
        'TAS': ['Hobart', 'Launceston', 'Devonport', 'Burnie', 'Ulverstone', 'Wynnum', 'Glenorchy'],
        'ACT': ['Canberra', 'Queanbeyan', 'Gungahlin', 'Belconnen', 'Weston Creek', 'Tuggeranong', 'Woden Valley'],
        'NT': ['Darwin', 'Alice Springs', 'Palmerston', 'Katherine', 'Nhulunbuy', 'Tennant Creek', 'Yulara']
    }
};

function updateStates() {
    const countrySelect = document.querySelector('select[name="country"]');
    const stateSelect = document.getElementById('state-filter');
    const country = countrySelect.value;

    stateSelect.innerHTML = '<option value="">{{ __("All States") }}</option>';

    if (country && statesData[country]) {
        Object.entries(statesData[country]).forEach(([code, name]) => {
            const option = document.createElement('option');
            option.value = code;
            option.textContent = name;
            stateSelect.appendChild(option);
        });
    }

    updateCities();
}

function updateCities() {
    const countrySelect = document.querySelector('select[name="country"]');
    const stateSelect = document.getElementById('state-filter');
    const citySelect = document.getElementById('city-filter');
    const country = countrySelect.value;
    const state = stateSelect.value;

    citySelect.innerHTML = '<option value="">{{ __("All Cities") }}</option>';

    if (country && state && citiesData[country] && citiesData[country][state]) {
        citiesData[country][state].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateStates();
});
</script>
@endsection
