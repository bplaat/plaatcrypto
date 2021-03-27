<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketsController extends Controller implements MessageComponentInterface {
    private $connections = [];

    public function onOpen(ConnectionInterface $connection) {
        $this->connections[$connection->resourceId] = ['connection' => $connection];
    }

    public function onMessage(ConnectionInterface $connection, $message) {
        echo $message . "\n";
    }

    public function onCoinUpdate(string $coinSymbol, float $price): void {
        foreach ($this->connections as $connection) {
            $connection['connection']->send(json_encode([
                'c' => $coinSymbol,
                'p' => $price
            ]));
        }
    }

    public function onClose(ConnectionInterface $connection) {
        unset($this->connections[$connection->resourceId]);
    }

    public function onError(ConnectionInterface $connection, \Exception $error) {
        echo 'Websockets Server error: ' . $error->getMessage() . "\n";

        unset($this->connections[$connection->resourceId]);
        $connection->close();
    }
}
