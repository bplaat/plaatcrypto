<?php

namespace App\Console\Commands;

use App\Http\Controllers\WebSocketsController;
use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Client\Connector;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server as Reactor;

class WebSocketsServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websockets:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the websockets server';

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
        $loop = Factory::create();

        // Connect to Binance websocket live feed API
        echo "Connecting to Binance websocket live feed API\n";
        $connector = new Connector($loop);
        $connector('wss://stream.binance.com:9443/ws/btcusdt@aggTrade')->then(function ($connection) {
            $connection->on('message', function ($message) use ($connection) {
                echo $message . "\n";
            });
        }, function ($error) {
            echo 'Could not connect to Binance websocket live feed API: ' . $error->getMessage() . "\n";
            exit;
        });

        // Start websocket server
        echo "Starting websockets server: ws://localhost:8080\n";
        $server = new IoServer(
            new HttpServer(
                new WsServer(
                    new WebSocketsController()
                )
            ),
            new Reactor('0.0.0.0:8080', $loop),
            $loop
        );

       $loop->run();
    }
}