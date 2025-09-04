<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitOrderPublisher
{
    private Rabbit $rabbit;

    public function __construct(Rabbit $rabbit)
    {
        $this->rabbit = $rabbit;
    }

    public function publishNewOrder(array $orderData): void
    {
        $channel = $this->rabbit->getChannel();
        $payload = json_encode($orderData, JSON_UNESCAPED_UNICODE);
        $msg = new AMQPMessage($payload, [
            'content_type'  => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ]);

        $channel->basic_publish($msg, 'laravel', 'newOrders');        
    }
}
