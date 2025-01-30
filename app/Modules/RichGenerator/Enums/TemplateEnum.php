<?php

declare(strict_types=1);

namespace App\Modules\RichGenerator\Enums;

enum TemplateEnum: string
{
    case TEMPLATE_1 = 'Шаблон 1';
    case TEMPLATE_2 = 'Шаблон 2';

    /**
     * Получить enum по значению.
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
     * Получить массив всех значений.
     */
    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }

    /**
     * Проверить, существует ли значение в enum.
     */
    public static function isValidValue(string $value): bool
    {
        return in_array($value, self::values(), true);
    }
}
