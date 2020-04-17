<?php

declare(strict_types=1);

namespace App\Utils\DropShipping\Client\BigBuy;

use App\Utils\DropShipping\Client\DropShippingClientFactoryInterface;
use App\Utils\DropShipping\Client\DropShippingClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClientFactory implements DropShippingClientFactoryInterface
{
    /** @var ParameterBagInterface */
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        $this->parameterBag = $parameterBagInterface;
    }

    public function createClient(): DropShippingClientInterface
    {
        return new Client($this->parameterBag);
    }
}
