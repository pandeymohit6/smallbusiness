<?php

declare(strict_types=1);

use App\Services\ImageService;
use App\Services\LanguageService;
use App\Services\MenuService\AdminMenuItem;
use App\Services\MenuService\AdminMenuService;
use App\Services\Modules\ModuleService;
use App\Services\PasswordService;
use App\Services\SlugService;
use Illuminate\Foundation\Vite;
use Illuminate\Database\Eloquent\Model;

if (! function_exists('get_module_asset_paths')) {
    function get_module_asset_paths(): array
    {
        return app(ModuleService::class)->getModuleAssetPath();
    }
}

/**
 * support for vite hot reload overriding manifest file.
 */
if (! function_exists('module_vite_compile')) {
    function module_vite_compile(string $module, string $asset, ?string $hotFilePath = null, $manifestFile = '.vite/manifest.json'): Vite
    {
        return app(ModuleService::class)
            ->moduleViteCompile($module, $asset, $hotFilePath, $manifestFile);
    }
}

/**
 * Invoke a method on the SettingService.
 *
 * @param  string  $method  The method name to invoke
 * @param  mixed  ...$parameters  The parameters to pass to the method
 *
 * @return mixed  The result of the method invocation
 */
if (! function_exists('invoke_setting')) {
    function invoke_setting(string $method, ...$parameters): mixed
    {
        $service = app(App\Services\SettingService::class);

        if (! method_exists($service, $method)) {
            throw new \InvalidArgumentException("Method {$method} does not exist on SettingService");
        }

        return $service->{$method}(...$parameters);
    }
}

/**
 * Add a new setting.
 *
 * @param  string  $optionName  The name of the setting option
 * @param  mixed  $optionValue  The value of the setting option
 * @param  bool  $autoload  Whether to autoload this setting (default: false)
 */
if (! function_exists('add_setting')) {
    function add_setting(string $optionName, mixed $optionValue, bool $autoload = false): void
    {
        invoke_setting('addSetting', $optionName, $optionValue, $autoload);
    }
}

/**
 * Update an existing setting.
 *
 * @param  string  $optionName  The name of the setting option
 * @param  mixed  $optionValue  The value of the setting option
 * @param  bool|null  $autoload  Whether to autoload this setting (default: null)
 */
if (! function_exists('update_setting')) {
    function update_setting(string $optionName, mixed $optionValue, ?bool $autoload = null): bool
    {
        return invoke_setting('updateSetting', $optionName, $optionValue, $autoload);
    }
}

/**
 * Delete a setting.
 *
 * @param  string  $optionName  The name of the setting option
 */
if (! function_exists('delete_setting')) {
    function delete_setting(string $optionName): bool
    {
        return invoke_setting('deleteSetting', $optionName);
    }
}

/**
 * Get a setting value.
 *
 * @param  string  $optionName  The name of the setting option
 * @param  mixed  $default  The default value if the setting does not exist
 *
 * @return mixed  The setting value or the default value
 */
if (! function_exists('get_setting')) {
    function get_setting(string $optionName, mixed $default = null): mixed
    {
        try {
            return invoke_setting('getSetting', $optionName) ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}

/**
 * Get all settings.
 *
 * @param  int|bool|null  $autoload  Autoload setting (default: true)
 * @return array  All settings
 */
if (! function_exists('get_settings')) {
    function get_settings(int|bool|null $autoload = true): array
    {
        return invoke_setting('getSettings', $autoload);
    }
}

/**
 * Store uploaded image and return its public URL.
 *
 * @param  \Illuminate\Http\Request|array  $input  Either the full request or a file from validated input
 * @param  string  $fileKey  The key name (e.g., 'photo')
 * @param  string  $path  Target relative path (e.g., 'uploads/contacts')
 */
if (! function_exists('store_image_url')) {
    function store_image_url($input, string $fileKey, string $path): ?string
    {
        return app(ImageService::class)
            ->storeImageAndGetUrl($input, $fileKey, $path);
    }
}

/**
 * Delete an image from the public path.
 *
 * @param  string  $imageUrl  The URL of the image to delete
 * @return bool  True if the image was deleted, false otherwise
 */
if (! function_exists('delete_image_from_public_path')) {
    function delete_image_from_public_path(string $imageUrl): bool
    {
        return app(ImageService::class)
            ->deleteImageFromPublic($imageUrl);
    }
}

/**
 * Add a menu item to the admin sidebar.
 *
 * @param  array|AdminMenuItem  $item  The menu item configuration array or instance
 * @param  string|null  $group  The group to add the item to (defaults to 'Main')
 */
if (! function_exists('add_menu_item')) {
    function add_menu_item(array|AdminMenuItem $item, ?string $group = null): void
    {
        app(AdminMenuService::class)->addMenuItem($item, $group);
    }
}

/**
 * Get the list of available languages with their flags.
 */
if (! function_exists('get_languages')) {
    function get_languages(): array
    {
        return app(LanguageService::class)->getActiveLanguages();
    }
}

/**
 * Get the SVG icon for a given name.
 *
 * @param  string  $name  The name of the icon file (without .svg extension)
 * @param  string  $classes  Additional CSS classes to apply to the SVG
 * @param  string  $fallback  Fallback icon name if the SVG file does not exist
 * @return string  The SVG icon HTML or an Iconify icon if the SVG does not exist
 */
if (! function_exists('svg_icon')) {
    function svg_icon(string $name, string $classes = '', string $fallback = ''): string
    {
        return app(ImageService::class)
            ->getSvgIcon($name, $classes, $fallback);
    }
}

/**
 * Generate a unique slug for a given string.
 *
 * @param  string  $string  The base string to generate the slug from
 * @param  string  $column  The column name to check for uniqueness (default: 'slug')
 * @param  string  $separator  The separator to use in the slug (default: '-')
 * @param  Model|null  $model  The model instance if checking against an existing record
 *
 * @return string  The generated unique slug
 */
if (! function_exists('generate_unique_slug')) {
    function generate_unique_slug(string $string, string $column = 'slug', string $separator = '-', $model = null): string
    {
        return app(SlugService::class)
            ->generateSlugFromString(
                $string,
                $column,
                $separator,
                $model
            );
    }
}

/**
 * Generate a secure password.
 *
 * @param  int  $length  The length of the password
 * @param  bool  $includeSpecialChars  Whether to include special characters
 *
 * @return string  The generated password
 */
if (! function_exists('generate_secure_password')) {
    function generate_secure_password(int $length = 12, bool $includeSpecialChars = true): string
    {
        return app(PasswordService::class)
            ->generatePassword($length, $includeSpecialChars);
    }
}

/**
 * Get the current country.
 *
 * @return \App\Enums\Country|null
 */
if (! function_exists('current_country')) {
    function current_country(): ?\App\Enums\Country
    {
        return app(\App\Services\MultiCountryService::class)::current();
    }
}

/**
 * Get the current country value.
 *
 * @return string|null
 */
if (! function_exists('current_country_value')) {
    function current_country_value(): ?string
    {
        return app(\App\Services\MultiCountryService::class)::currentValue();
    }
}

/**
 * Check if the current country matches the given country.
 *
 * @param  \App\Enums\Country  $country
 *
 * @return bool
 */
if (! function_exists('is_country')) {
    function is_country(\App\Enums\Country $country): bool
    {
        return app(\App\Services\MultiCountryService::class)::is($country);
    }
}

/**
 * Get URL for a specific country.
 *
 * @param  \App\Enums\Country  $country
 * @param  string  $path
 *
 * @return string
 */
if (! function_exists('country_url')) {
    function country_url(\App\Enums\Country $country, string $path = '/'): string
    {
        return app(\App\Services\MultiCountryService::class)::url($country, $path);
    }
}
/**
 * Check if viewing all countries (on main domain without country filter)
 *
 * @return bool
 */
if (! function_exists('is_viewing_all_countries')) {
    function is_viewing_all_countries(): bool
    {
        return app(\App\Services\MultiCountryService::class)::isViewingAll();
    }
}

/**
 * Get main/all countries URL
 *
 * @param  string  $path
 *
 * @return string
 */
if (! function_exists('all_countries_url')) {
    function all_countries_url(string $path = '/'): string
    {
        return app(\App\Services\MultiCountryService::class)::mainUrl($path);
    }
}
/**
 * Get all available countries.
 *
 * @return array
 */
if (! function_exists('get_all_countries')) {
    function get_all_countries(): array
    {
        return app(\App\Services\MultiCountryService::class)::all();
    }
}

/**
 * Get all countries with their details.
 *
 * @return array
 */
if (! function_exists('get_all_countries_with_details')) {
    function get_all_countries_with_details(): array
    {
        return app(\App\Services\MultiCountryService::class)::allWithDetails();
    }
}

/**
 * Get all available countries for location selection.
 *
 * @return array
 */
if (! function_exists('get_location_countries')) {
    function get_location_countries(): array
    {
        return [
            'United States' => __('United States'),
            'Canada' => __('Canada'),
            'Australia' => __('Australia'),
        ];
    }
}

/**
 * Get states for a specific country.
 *
 * @param  string  $country
 *
 * @return array
 */
if (! function_exists('get_location_states')) {
    function get_location_states(string $country): array
    {
        return \App\Models\Business::getStatesByCountry($country);
    }
}

/**
 * Get cities for a specific country and state.
 *
 * @param  string  $country
 * @param  string  $state
 *
 * @return array
 */
if (! function_exists('get_location_cities')) {
    function get_location_cities(string $country, string $state): array
    {
        return \App\Models\Business::getCitiesByCountryAndState($country, $state);
    }
}

/**
 * Format location display (country, state, city).
 *
 * @param  string|null  $country
 * @param  string|null  $state
 * @param  string|null  $city
 *
 * @return string
 */
if (! function_exists('format_location')) {
    function format_location(?string $country = null, ?string $state = null, ?string $city = null): string
    {
        $parts = [];
        
        if ($city) {
            $parts[] = $city;
        }
        if ($state) {
            $parts[] = $state;
        }
        if ($country) {
            $parts[] = $country;
        }
        
        return implode(', ', $parts) ?: 'Unknown Location';
    }
}
