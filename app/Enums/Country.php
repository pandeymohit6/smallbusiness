<?php

declare(strict_types=1);

namespace App\Enums;

enum Country: string
{
    case USA = 'usa';
    case CANADA = 'canada';
    case AUSTRALIA = 'aus';

    public function label(): string
    {
        return match ($this) {
            self::USA => 'United States',
            self::CANADA => 'Canada',
            self::AUSTRALIA => 'Australia',
        };
    }

    public function code(): string
    {
        return match ($this) {
            self::USA => 'US',
            self::CANADA => 'CA',
            self::AUSTRALIA => 'AU',
        };
    }

    public function currency(): string
    {
        return match ($this) {
            self::USA => 'USD',
            self::CANADA => 'CAD',
            self::AUSTRALIA => 'AUD',
        };
    }

    public static function all(): array
    {
        return self::cases();
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
