@csrf

@if($business->exists)
    @method('PUT')
@endif

<div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
    <div class="lg:col-span-2">
        <label class="form-label" for="title">{{ __('Title') }}</label>
        <input id="title" name="title" class="form-control" value="{{ old('title', $business->title) }}" required>
        @error('title')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label" for="business_type">{{ __('Business Type') }}</label>
        <select id="business_type" name="business_type" class="form-control" required>
            @foreach($businessTypes as $value => $label)
                <option value="{{ $value }}" @selected(old('business_type', $business->business_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label" for="industry">{{ __('Industry') }}</label>
        <select id="industry" name="industry" class="form-control" required>
            @foreach($industries as $value => $label)
                <option value="{{ $value }}" @selected(old('industry', $business->industry) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="form-label" for="location">{{ __('Location') }}</label>
        <input id="location" name="location" class="form-control" value="{{ old('location', $business->location ?? '') }}" required>
    </div>

    <div>
        <label class="form-label" for="country_code">{{ __('Country') }}</label>
        <select id="country_code" name="country_code" class="form-control" required onchange="updateStates()">
            <option value="">{{ __('Select Country') }}</option>
            @php
                $countries = [
                    'United States' => __('United States'),
                    'Canada' => __('Canada'),
                    'Australia' => __('Australia'),
                ];
            @endphp
            @foreach($countries as $value => $label)
                <option value="{{ $value }}" @selected(old('country_code', $business->country_code ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('country_code')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label" for="state">{{ __('State/Province') }}</label>
        <select id="state" name="state" class="form-control" required onchange="updateCities()">
            <option value="">{{ __('Select State') }}</option>
        </select>
        @error('state')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label" for="city">{{ __('City') }}</label>
        <select id="city" name="city" class="form-control" required>
            <option value="">{{ __('Select City') }}</option>
        </select>
        @error('city')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label" for="asking_price">{{ __('Asking Price') }}</label>
        <input id="asking_price" name="asking_price" type="number" min="0" step="0.01" class="form-control" value="{{ old('asking_price', $business->asking_price) }}" required>
    </div>

    <div>
        <label class="form-label" for="annual_revenue">{{ __('Annual Revenue') }}</label>
        <input id="annual_revenue" name="annual_revenue" type="number" min="0" step="0.01" class="form-control" value="{{ old('annual_revenue', $business->annual_revenue) }}">
    </div>

    <div>
        <label class="form-label" for="annual_profit">{{ __('Annual Profit') }}</label>
        <input id="annual_profit" name="annual_profit" type="number" min="0" step="0.01" class="form-control" value="{{ old('annual_profit', $business->annual_profit) }}">
    </div>

    <div>
        <label class="form-label" for="years_in_operation">{{ __('Years in Operation') }}</label>
        <input id="years_in_operation" name="years_in_operation" type="number" min="0" class="form-control" value="{{ old('years_in_operation', $business->years_in_operation) }}">
    </div>

    <div>
        <label class="form-label" for="employees">{{ __('Employees') }}</label>
        <input id="employees" name="employees" type="number" min="0" class="form-control" value="{{ old('employees', $business->employees) }}">
    </div>

    @if($business->exists)
        <div>
            <label class="form-label" for="status">{{ __('Status') }}</label>
            <select id="status" name="status" class="form-control" required>
                @foreach(\App\Models\Business::getStatuses() as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $business->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label" for="published_at">{{ __('Published At') }}</label>
            <input id="published_at" name="published_at" type="datetime-local" class="form-control" value="{{ old('published_at', optional($business->published_at)->format('Y-m-d\TH:i')) }}">
        </div>
    @endif

    <div class="lg:col-span-2">
        <label class="form-label" for="description">{{ __('Description') }}</label>
        <textarea id="description" name="description" rows="5" class="form-control" required>{{ old('description', $business->description) }}</textarea>
    </div>

    <div class="lg:col-span-2">
        <label class="form-label" for="overview">{{ __('Overview') }}</label>
        <textarea id="overview" name="overview" rows="4" class="form-control">{{ old('overview', $business->overview) }}</textarea>
    </div>

    <div>
        <label class="form-label" for="features">{{ __('Features') }}</label>
        <textarea id="features" name="features" rows="4" class="form-control">{{ old('features', $business->features) }}</textarea>
    </div>

    <div>
        <label class="form-label" for="highlights">{{ __('Highlights') }}</label>
        <textarea id="highlights" name="highlights" rows="4" class="form-control">{{ old('highlights', $business->highlights) }}</textarea>
    </div>

    @can('business.manage')
        <div class="lg:col-span-2">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $business->is_featured))>
                {{ __('Featured listing') }}
            </label>
        </div>
    @endcan
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="btn-primary">{{ $business->exists ? __('Update Listing') : __('Create Listing') }}</button>
    <a href="{{ route('admin.business.index') }}" class="btn-secondary">{{ __('Cancel') }}</a>
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
    const countrySelect = document.getElementById('country_code');
    const stateSelect = document.getElementById('state');
    const country = countrySelect.value;

    stateSelect.innerHTML = '<option value="">{{ __("Select State") }}</option>';

    if (country && statesData[country]) {
        Object.entries(statesData[country]).forEach(([code, name]) => {
            const option = document.createElement('option');
            option.value = code;
            option.textContent = name;
            stateSelect.appendChild(option);
        });
    }

    // Reset city
    updateCities();
}

function updateCities() {
    const countrySelect = document.getElementById('country_code');
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const country = countrySelect.value;
    const state = stateSelect.value;

    citySelect.innerHTML = '<option value="">{{ __("Select City") }}</option>';

    if (country && state && citiesData[country] && citiesData[country][state]) {
        citiesData[country][state].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateStates();
    if (document.getElementById('state').value) {
        updateCities();
    }
});
</script>
