<?php

declare(strict_types=1);

namespace App\Form\Extension;

use App\Utils\ColorResolver;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    /** @var ColorResolver */
    private $colorResolver;

    public function __construct(ColorResolver $colorResolver)
    {
        $this->colorResolver = $colorResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('color', ChoiceType::class, [
            'placeholder' => 'Choose an option',
            'choices' => $this->colorResolver->getColorsChoices(),
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
