<?php


namespace App\Tests\Unit\Utils;


use App\Utils\ColorResolver;
use PHPUnit\Framework\TestCase;

class ColorResolverTest extends TestCase
{
    /** @var ColorResolver */
    private $colorResolver;

    public function setUp() {
        parent::setUp();

        $this->colorResolver = new ColorResolver();
    }

    public function testItReturnsCorrectColorArray() {
        $colors = $this->colorResolver->getColors();
        $this->assertTrue(is_array($colors));
        $this->assertEquals(ColorResolver::COLORS, $colors);
    }

    public function testItDoesNotReturnIncorrectColorArray() {
        $colors = $this->colorResolver->getColors();
        $incorrectColors = ['yellow'];
        $this->assertNotEquals($incorrectColors, $colors);
    }

    public function testItReturnsCorrectChoicesColorArray() {
        $colors = $this->colorResolver->getColorsChoices();
        $this->assertTrue(is_array($colors));
        $expectedArray = [];
        foreach (ColorResolver::COLORS as $color) {
            $expectedArray[ucfirst($color)] = $color;
        }
        $this->assertEquals($expectedArray, $colors);
    }

    public function testItDoesNotReturnIncorrectChoicesColorArray() {
        $colors = $this->colorResolver->getColorsChoices();
        $this->assertTrue(is_array($colors));
        $expectedArray = [];
        foreach (ColorResolver::COLORS as $color) {
            $expectedArray[$color] = $color;
        }
        $this->assertNotEquals($expectedArray, $colors);
    }
}
