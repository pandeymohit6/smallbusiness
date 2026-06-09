<?php

declare(strict_types=1);

namespace App\Enums;

enum Country: string
{
    case USA = 'usa';
    case CANADA = 'can';
    case AUSTRALIA = 'aus';

    /**
     * Get the display label for the country
     */
    public function label(): string
    {
        return match ($this) {
            self::USA => 'United States',
            self::CANADA => 'Canada',
            self::AUSTRALIA => 'Australia',
        };
    }

    /**
     * Get the ISO 3166-1 alpha-2 country code
     */
    public function code(): string
    {
        return match ($this) {
            self::USA => 'us',
            self::CANADA => 'ca',
            self::AUSTRALIA => 'au',
        };
    }

    /**
     * Get the currency code for the country
     */
    public function currency(): string
    {
        return match ($this) {
            self::USA => 'USD',
            self::CANADA => 'CAD',
            self::AUSTRALIA => 'AUD',
            self::INDIA => 'INR',
        };
    }

    /**
     * Get all country cases
     */
    public static function all(): array
    {
        return self::cases();
    }

    /**
     * Get all country enum values (e.g., 'usa', 'canada', 'aus')
     */
    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    /**
     * Get all country labels (e.g., 'United States', 'Canada', 'Australia')
     */
    public static function labels(): array
    {
        return array_map(fn ($case) => $case->label(), self::cases());
    }

    /**
     * Get all country codes (e.g., 'US', 'CA', 'AU')
     */
    public static function codes(): array
    {
        return array_map(fn ($case) => $case->code(), self::cases());
    }

    /**
     * Create from label (e.g., 'United States' -> USA)
     */
    public static function fromLabel(string $label): ?self
    {
        foreach (self::cases() as $country) {
            if ($country->label() === $label) {
                return $country;
            }
        }
        return null;
    }

    /**
     * Create from ISO code (e.g., 'US' -> USA)
     */
    public static function fromCode(string $code): ?self
    {
        foreach (self::cases() as $country) {
            if ($country->code() === strtoupper($code)) {
                return $country;
            }
        }
        return null;
    }

    /**
     * Get as associative array with all details
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->label(),
            'code' => $this->code(),
            'currency' => $this->currency(),
        ];
    }

    /**
     * Get all countries as associative array
     */
    public static function allAsArray(): array
    {
        $result = [];
        foreach (self::cases() as $country) {
            $result[$country->value] = $country->toArray();
        }
        return $result;
    }

    /**
     * Get all countries as select options (value => label)
     */
    public static function selectOptions(): array
    {
        $options = [];
        foreach (self::cases() as $country) {
            $options[$country->value] = $country->label();
        }
        return $options;
    }
}
