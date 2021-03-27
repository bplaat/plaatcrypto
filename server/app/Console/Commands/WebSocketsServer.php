<?php

namespace App\Console\Commands;

use App\Http\Controllers\WebSocketsController;
use App\Models\Coin;
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

        // Connect to Binance websocket live feed
        $connector = new Connector($loop);

        $coins = Coin::all();
        $coinsData = [];
        $streamsString = [];
        foreach ($coins as $coin) {
            $coinsData[$coin->symbol] = [
                'positionsCache' => [],
                'positionsTime' => microtime(true),
                'positionsUpdateTime' => microtime(true)
            ];
            $streamsString[] = strtolower($coin->symbol) . 'usdt@aggTrade';
        }

        $url = 'wss://stream.binance.com:9443/stream?streams=' . implode('/', $streamsString);
        echo 'Connecting to Binance websocket live feed: ' . $url . "\n";
        $connector($url)->then(function ($connection) use (&$coins, &$coinsData) {
            $connection->on('message', function ($message) use (&$coins, &$coinsData, $connection) {
                $message = json_decode($message);
                $coinSymbol = strtoupper(str_replace('usdt@aggTrade', '', $message->stream));
                $coin = $coins->first(function ($coin) use ($coinSymbol) {
                    return $coin->symbol == $coinSymbol;
                });
                $coinData = &$coinsData[$coinSymbol];


                // Add position to cache per second
                if (microtime(true) - $coinData['positionsUpdateTime'] < 60) {
                    if (microtime(true) - $coinData['positionsTime'] >= 1) {
                        echo '1 ' . $coinSymbol . ' = ' . $message->data->p . " USDT \n";
                        $coinData['positionsCache'][] = (float)$message->data->p;
                        $coinData['positionsTime'] = microtime(true);
                    }
                } else {
                    // Fit positions cache
                    $length = count($coinData['positionsCache']);
                    if ($length < 60) {
                        $last = $coinData['positionsCache'][$length - 1];
                        for ($i = 0; $i < 60 - $length; $i++) {
                            $coinData['positionsCache'][] = $last;
                        }
                    }

                    // Insert last period of positions to database
                    $prices = json_encode($coinData['positionsCache']);
                    echo 'Insert ' . $coinSymbol . ' ' . count($coinData['positionsCache']) . ' postions: ' . $prices . "\n";
                    $coin->positions()->create([
                        'prices' => $prices,
                        'created_at' => date('Y-m-d H:i:s', $coinData['positionsUpdateTime']),
                        'updated_at' => date('Y-m-d H:i:s', $coinData['positionsUpdateTime'])
                    ]);

                    // Clear positions cache
                    $coinData['positionsCache'] = [];
                    $coinData['positionsUpdateTime'] = microtime(true);
                }
            });
        }, function ($error) {
            echo 'Could not connect to Binance websocket live feed: ' . $error->getMessage() . "\n";
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
