<?php

declare(strict_types=1);

namespace App\EmailManager;

use Sylius\Component\Core\Model\OrderInterface;

interface OrderNotificationEmailManagerInterface
{
    public function notify(OrderInterface $order): void;
}
