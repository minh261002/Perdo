<?php

namespace App\Supports;
use Illuminate\Support\Facades\Lang;

trait Enum
{
    public static function getCases(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function asSelectArray()
    {
        $array = [];
        foreach (self::cases() as $item) {
            $array[$item->value] = $item->getDescription($item->value);
        }
        return $array;
    }

    public static function getLocalizationKey(): string
    {
        return 'enums.' . static::class;
    }

    protected static function getLocalizedDescription(mixed $value): ?string
    {
        $localizedStringKey = static::getLocalizationKey() . '.' . $value;

        if (Lang::has($localizedStringKey)) {
            return __($localizedStringKey);
        }

        return null;
    }

    protected static function getAttributeDescription($value)
    {
        return self::from($value)->name;
    }

    public function description()
    {
        return self::getDescription($this->value);
    }

    public static function getDescription(mixed $value): string
    {
        return
            static::getLocalizedDescription($value) ??
            static::getAttributeDescription($value);
    }
}