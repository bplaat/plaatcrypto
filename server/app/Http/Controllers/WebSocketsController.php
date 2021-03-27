<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketsController extends Controller implements MessageComponentInterface {
    private $connections = [];

    function onOpen(ConnectionInterface $connection) {
        $this->connections[$connection->resourceId] = ['connection' => $connection];
    }

    function onMessage(ConnectionInterface $connection, $message) {
        echo $message . "\n";

        $connection->send(json_encode([
            'coins' => Coin::all()
        ]));
    }

    function onClose(ConnectionInterface $connection) {
        unset($this->connections[$connection->resourceId]);
    }

    function onError(ConnectionInterface $connection, \Exception $error) {
        echo 'Error: ' . $error->getMessage() . "\n";

        unset($this->connections[$connection->resourceId]);
        $connection->close();
    }
}
