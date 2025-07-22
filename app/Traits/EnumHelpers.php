<?php

namespace App\Traits;

trait EnumHelpers
{
    /**
     * Get all enum values as an array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all enum names as an array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Get enum case by value
     */
    public static function fromValue(string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }

    /**
     * Check if value exists in enum
     */
    public static function hasValue(string $value): bool
    {
        return in_array($value, self::values());
    }

    /**
     * Get random enum case
     */
    public static function random(): self
    {
        return self::cases()[array_rand(self::cases())];
    }

    /**
     * Get enum options for select inputs
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = method_exists($case, 'label') ? $case->label() : $case->name;
        }
        return $options;
    }
}
