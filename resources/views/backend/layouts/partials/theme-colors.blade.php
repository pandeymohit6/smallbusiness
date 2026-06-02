@php
use App\Services\ThemeColorService;

$primaryColor = config('settings.theme_primary_color');
if ($primaryColor === null || $primaryColor === '') {
    $primaryColor = get_setting('theme_primary_color', '#635bff');
    config(['settings.theme_primary_color' => $primaryColor]);
}

$secondaryColor = config('settings.theme_secondary_color');
if ($secondaryColor === null || $secondaryColor === '') {
    $secondaryColor = get_setting('theme_secondary_color', '#1f2937');
    config(['settings.theme_secondary_color' => $secondaryColor]);
}

$primaryPalette = ThemeColorService::generateColorPalette($primaryColor);
@endphp

<style>
    :root {
        /* Base colors */
        --color-primary: {{ $primaryColor }};
        --color-secondary: {{ $secondaryColor }};
        
        /* Brand color palette */
        --color-brand-50: {{ $primaryPalette[50] }};
        --color-brand-100: {{ $primaryPalette[100] }};
        --color-brand-200: {{ $primaryPalette[200] }};
        --color-brand-300: {{ $primaryPalette[300] }};
        --color-brand-400: {{ $primaryPalette[400] }};
        --color-brand-500: {{ $primaryColor }};
        --color-brand-600: {{ $primaryPalette[600] }};
        --color-brand-700: {{ $primaryPalette[700] }};
        --color-brand-800: {{ $primaryPalette[800] }};
        --color-brand-900: {{ $primaryPalette[900] }};
    }
</style>
