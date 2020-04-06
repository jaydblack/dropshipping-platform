<?php

declare(strict_types=1);

namespace App\Utils;

class ColorResolver
{
    const BLUE = 'blue';
    const GREEN = 'green';
    const RED = 'red';

    const COLORS = [
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
