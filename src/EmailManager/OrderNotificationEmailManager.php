<?php

declare(strict_types=1);

namespace App\EmailManager;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

class OrderNotificationEmailManager implements OrderNotificationEmailManagerInterface
{
    /** @var SenderInterface */
    private $sender;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(
        SenderInterface $sender,
        ChannelContextInterface $channelContext
    ) {
        $this->sender = $sender;
        $this->channelContext = $channelContext;
    }

    public function notify(OrderInterface $order): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();
        $this->sender->send(
            'order_notification',
            ['email@example.com'],
            ['order' => $order, 'channel' => $channel]
        );
    }
}
