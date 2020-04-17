<?php

declare(strict_types=1);

namespace App\Utils\DropShipping\Client;

use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;

interface DropShippingClientInterface
{
    public function getProductsByCategory(int $categoryId): ArrayCollection;

    public function setHttpClient(Client $client): void;
}
