<?php

declare(strict_types=1);

namespace App\Utils\DropShipping\Client;

use Doctrine\Common\Collections\ArrayCollection;

interface DropShippingClientInterface
{
    public function findProductByKeyword(string $keyword, array $categoryIds = []): ArrayCollection;
}
