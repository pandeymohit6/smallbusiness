# Subdomain Flow Refactor to Country/State/City Filtering

## Overview
The application has been refactored to remove subdomain-based database filtering and replace it with explicit country, state, and city form fields. Subdomains are now used for UI/routing purposes only.

## Key Changes

### 1. Database Schema
**New Migration**: `database/migrations/2026_06_02_000000_add_state_city_to_tables.php`

Added `state` and `city` columns to:
- `businesses` table
- `users` table
- `posts` table
- `enquiries` table

```sql
ALTER TABLE businesses ADD COLUMN state VARCHAR(255) NULLABLE AFTER location;
ALTER TABLE businesses ADD COLUMN city VARCHAR(255) NULLABLE AFTER state;
```

### 2. Middleware Changes
**File**: `app/Http/Middleware/CountryMiddleware.php`

**Changes**:
- Removed automatic `session('country')` setting based on subdomain
- Subdomains are now stored in request attributes for UI routing only
- No automatic database filtering happens

**Before**:
```php
// Subdomain = 'usa' → session('country') = 'usa' → filters queries
```

**After**:
```php
// Subdomain = 'usa' → request attributes('subdomain') = 'usa' → UI routing only
```

### 3. Model Updates
**File**: `app/Models/Business.php`

**New Properties**:
```php
protected $fillable = [
    'country_code',  // e.g., "United States", "Canada", "Australia"
    'state',         // State/Province code: CA, NY, ON, QC, etc.
    'city',          // City name: Los Angeles, Toronto, Sydney, etc.
    // ... other fields
];
```

**New Scopes**:
```php
// Filter by country
Business::byCountry('United States')->get();

// Filter by state
Business::byState('CA')->get();

// Filter by city
Business::byCity('Los Angeles')->get();

// Filter by country and state
Business::byCountryAndState('United States', 'CA')->get();

// Filter by country, state, and city
Business::byCountryStateCity('United States', 'CA', 'Los Angeles')->get();
```

**New Static Methods**:
```php
// Get all countries
Business::getCountries();
// Returns: ['United States' => 'United States', 'Canada' => 'Canada', 'Australia' => 'Australia']

// Get states for a country
Business::getStatesByCountry('United States');
// Returns: ['CA' => 'California', 'NY' => 'New York', ...]

// Get cities for country and state
Business::getCitiesByCountryAndState('United States', 'CA');
// Returns: ['Los Angeles', 'San Francisco', 'San Diego', ...]
```

### 4. CountryScope Changes
**File**: `app/Models/Scopes/CountryScope.php`

**Changes**:
- Disabled automatic filtering
- Now kept for backward compatibility but doesn't filter queries
- Developers must use explicit scopes

**Before**:
```php
// Automatic filtering based on session('country')
Business::all(); // Always filtered by country
```

**After**:
```php
// No automatic filtering
Business::all(); // Returns all records

// Explicit filtering required
Business::byCountry('United States')->get(); // Only USA
```

### 5. Backend Controller Updates
**File**: `app/Http/Controllers/Backend/BusinessController.php`

**Validation Changes**:
```php
$validated = $request->validate([
    'country_code' => ['required', 'string', 'in:United States,Canada,Australia'],
    'state' => ['required', 'string'],
    'city' => ['required', 'string'],
    // ... other fields
]);
```

**Index Filtering**:
```php
// Added country/state/city filters
if ($request->filled('country')) {
    $query->where('country_code', $request->input('country'));
}

if ($request->filled('state')) {
    $query->where('state', $request->input('state'));
}

if ($request->filled('city')) {
    $query->where('city', $request->input('city'));
}
```

**View Data**:
```php
return view('backend.pages.business.create', [
    'countries' => Business::getCountries(),
    // ... other data
]);
```

### 6. Frontend Controller Updates
**File**: `app/Http/Controllers/PublicBusinessController.php`

**Index Filtering**:
```php
if ($request->filled('country')) {
    $query->where('country_code', $request->input('country'));
}

if ($request->filled('state')) {
    $query->where('state', $request->input('state'));
}

if ($request->filled('city')) {
    $query->where('city', $request->input('city'));
}
```

### 7. Form Views

#### Backend Form: `resources/views/backend/pages/business/partials/form.blade.php`
**New Fields**:
- Country dropdown (United States, Canada, Australia)
- State/Province dropdown (dynamically populated)
- City dropdown (dynamically populated)

**JavaScript Features**:
- Dynamic state population when country changes
- Dynamic city population when state changes
- Cascading dropdown behavior

#### Frontend Index: `resources/views/business/index.blade.php`
**New Filters**:
- Country dropdown filter
- State/Province dropdown filter (dynamic)
- City dropdown filter (dynamic)

**Search Fields**:
- Search by title or location
- Filter by type and industry (existing)

#### Frontend Show: `resources/views/business/show.blade.php`
**Display Changes**:
- Uses `format_location()` helper to display location
- Shows full address: City, State, Country

### 8. Helper Functions
**File**: `app/Support/Helper/common.php`

**New Helpers**:
```php
// Get all available countries
get_location_countries(); 
// Returns: ['United States' => 'United States', ...]

// Get states for a country
get_location_states('United States');
// Returns: ['CA' => 'California', ...]

// Get cities for country and state
get_location_cities('United States', 'CA');
// Returns: ['Los Angeles', 'San Francisco', ...]

// Format location display
format_location('United States', 'CA', 'Los Angeles');
// Returns: "Los Angeles, CA, United States"
```

### 9. Livewire Component
**File**: `app/Livewire/Backend/BusinessForm.php`

**New Properties**:
```php
public string $country = '';
public string $state = '';
public string $city = '';
```

**New Methods**:
```php
// Reset state and city when country changes
public function updatedCountry(): void

// Reset city when state changes
public function updatedState(): void
```

**Dynamic Data**:
```php
return view('livewire.backend.business-form', [
    'countries' => Business::getCountries(),
    'states' => $this->country ? Business::getStatesByCountry($this->country) : [],
    'cities' => ($this->country && $this->state) ? Business::getCitiesByCountryAndState($this->country, $this->state) : [],
]);
```

## Migration Path

### Step 1: Run Migration
```bash
php artisan migrate
```

This adds `state` and `city` columns to all relevant tables.

### Step 2: Update Existing Data
For existing businesses without state/city, you can run a command or manually populate:
```php
// Example: Set default state/city for existing records
Business::whereNull('state')->update(['state' => '', 'city' => '']);
```

### Step 3: Update Subdomain Usage
If you were using subdomains for database filtering:
- Stop relying on subdomains for data filtering
- Use explicit queries with country/state/city
- Subdomains are now optional for UI routing

## Query Examples

### Get All Businesses
```php
// Get all businesses (no filtering)
Business::all();

// Get only USA businesses
Business::byCountry('United States')->get();

// Get only California businesses
Business::byCountry('United States')->byState('CA')->get();

// Get only Los Angeles businesses
Business::byCountry('United States')->byState('CA')->byCity('Los Angeles')->get();
```

### With Pagination
```php
Business::byCountry('United States')
    ->byState('CA')
    ->active()
    ->paginate(15);
```

### Complex Queries
```php
// Get active California or Texas businesses
Business::active()
    ->byCountry('United States')
    ->where(function ($q) {
        $q->where('state', 'CA')
          ->orWhere('state', 'TX');
    })
    ->get();
```

## Frontend Usage

### Display Location
```blade
{{ format_location($business->country_code, $business->state, $business->city) }}
<!-- Output: "Los Angeles, CA, United States" -->
```

### Get Filter Options
```blade
@foreach(get_location_countries() as $value => $label)
    <option value="{{ $value }}">{{ $label }}</option>
@endforeach
```

## Subdomain Behavior

### Subdomains in URLs
Subdomains are still valid for UI routing but don't affect data filtering:

- `localhost:8000` - Main site
- `usa.localhost:8000` - USA UI theme (if implemented)
- `canada.localhost:8000` - Canada UI theme (if implemented)
- `aus.localhost:8000` - Australia UI theme (if implemented)

The subdomain is stored in `request('subdomain')` for UI purposes.

## Troubleshooting

### Issue: Records Not Filtered by Country
**Solution**: Use explicit scopes:
```php
// ✅ Correct
Business::byCountry('United States')->get();

// ❌ Won't filter
Business::all(); // Returns all, not filtered
```

### Issue: State/City Not Populated
**Solution**: Verify country_code value and use correct codes:
```php
// Valid countries
'United States', 'Canada', 'Australia'

// Valid state codes for USA
'CA', 'NY', 'TX', etc.

// Valid cities
'Los Angeles', 'New York', etc.
```

### Issue: Form Not Showing Dropdowns
**Solution**: Ensure JavaScript is loaded and country value is set:
```blade
// In form view
<select id="country_code" name="country_code" 
        onchange="updateStates()">
    <option value="">{{ __('Select Country') }}</option>
    @foreach($countries as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
```

## Future Enhancements

1. **Database-Driven Locations**: Move country/state/city data to database tables
2. **More Countries**: Extend the system to support additional countries
3. **REST API**: Create API endpoints for country/state/city data
4. **Location-Based Pricing**: Different pricing by region
5. **Regional Settings**: Region-specific configurations and settings

## Summary of Files Changed

| File | Type | Changes |
|------|------|---------|
| `database/migrations/2026_06_02_000000_add_state_city_to_tables.php` | New | Added state/city columns |
| `app/Http/Middleware/CountryMiddleware.php` | Modified | Removed subdomain filtering |
| `app/Models/Scopes/CountryScope.php` | Modified | Disabled auto filtering |
| `app/Models/Business.php` | Modified | Added scopes and methods |
| `app/Http/Controllers/Backend/BusinessController.php` | Modified | Added validation and filtering |
| `app/Http/Controllers/PublicBusinessController.php` | Modified | Added filtering |
| `app/Livewire/Backend/BusinessForm.php` | Modified | Added location fields |
| `app/Support/Helper/common.php` | Modified | Added location helpers |
| `resources/views/backend/pages/business/partials/form.blade.php` | Modified | Added location dropdowns |
| `resources/views/business/index.blade.php` | Modified | Added location filters |
| `resources/views/business/show.blade.php` | Modified | Display location info |

## Testing

### Test Cases

1. **Create Business with Location**
   - Create business with all country/state/city fields
   - Verify data is saved correctly

2. **Filter Businesses**
   - Filter by country
   - Filter by state
   - Filter by city
   - Verify correct results

3. **Dynamic Dropdowns**
   - Change country dropdown
   - Verify state dropdown updates
   - Change state dropdown
   - Verify city dropdown updates

4. **Public Listing**
   - View public listing with location
   - Search by location filters
   - Verify filtering works

## Rollback Instructions

If you need to revert these changes:

```bash
# Rollback migration
php artisan migrate:rollback

# Remove new helper functions from common.php
# Restore original CountryMiddleware
# Restore original Models and Controllers
```
