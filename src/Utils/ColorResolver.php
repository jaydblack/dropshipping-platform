<?php

declare(strict_types=1);

namespace App\Utils;

class ColorResolver
{
    public const BLUE = 'blue';

    public const GREEN = 'green';

    public const RED = 'red';

    public const COLORS = [
        self::BLUE,
        self::GREEN,
        self::RED,
    ];

    public function getColors()
    {
        return self::COLORS;
    }

    public function getColorsChoices()
    {
        $colorChoices = [];
        foreach (self::COLORS as $color) {
            $colorChoices[ucfirst($color)] = $color;
        }

        return $colorChoices;
    }
}
