<?php

declare(strict_types=1);

namespace App\Utils\DropShipping\Client;

interface DropShippingClientFactoryInterface
{
    public function createClient(): DropShippingClientInterface;
}
