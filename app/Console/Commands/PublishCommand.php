<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        // создаем обменник
        $channel->exchange_declare('laravel', 'direct', false, true, false);
        // создаём очередь
        $channel->queue_declare('hello', false, true, false, false);
        // связываем очередь с exchange, routing key = "hello"
        $channel->queue_bind('hello','laravel','hello');
        $msg = new AMQPMessage('Hello World3!');
        $channel->basic_publish($msg,'laravel','hello');

        echo " [x] Sent 'Hello World!'\n";
        
        $channel->close();
        $connection->close();
    }
}
