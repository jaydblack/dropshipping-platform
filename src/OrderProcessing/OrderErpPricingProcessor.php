<?php

declare(strict_types=1);

namespace App\OrderProcessing;

use Psr\Log\LoggerInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderErpPricingProcessor implements OrderProcessorInterface
{
    /** @var LoggerInterface */
    private $logger;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(LoggerInterface $logger, EventDispatcherInterface $eventDispatcher)
    {
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function process(OrderInterface $order): void
    {
        try {
            file_get_contents('https://example.com');
        } catch (\Exception $erpConnectionException) {
            $this->logger->log('error', sprintf(
                'Could not connect to the ERP system. Message: %s.',
                $erpConnectionException->getMessage()
            ));

            $this->eventDispatcher->dispatch('app.erp_connection.fail');
        }
    }
}
