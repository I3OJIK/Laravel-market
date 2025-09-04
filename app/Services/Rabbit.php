<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Создание подключения к RabbitMQ и создание очередей, обменников, биндов
 * 
 * @property AMQPStreamConnection $connection
 * @property AMQPChannel $channel
 */
class Rabbit
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        // Подключение к RabbitMQ
        $this->connection = new AMQPStreamConnection(
            'rabbitmq', 5672, 'guest', 'guest'
        );
        $this->channel = $this->connection->channel();

        // Объявляем exchange и очередь 
        $this->channel->exchange_declare('laravel', 'direct', false, true, false);
        $this->channel->queue_declare('newOrders', false, true, false, false);
        $this->channel->queue_bind('newOrders', 'laravel', 'newOrders');
    }

    /**
     * Получить channel
     * 
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * Закрыть соединение
     * 
     * @return void
     */
    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
