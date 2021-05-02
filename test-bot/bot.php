<?php

require_once 'vendor/autoload.php';

class Database {
    protected static ?PDO $pdo = null;

    protected static int $queryCount;

    public static function connect(string $dsn, ?string $user = null, ?string $password = null): void {
        static::$pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        static::$queryCount = 0;
    }

    public static function disconnect(): void {
        static::$pdo = null;
    }

    public static function queryCount(): int {
        return static::$queryCount;
    }

    public static function lastInsertId(): int {
        return static::$pdo->lastInsertId();
    }

    public static function query(string $query, ...$parameters): PDOStatement {
        $statement = static::$pdo->prepare($query);
        $statement->execute($parameters);
        static::$queryCount++;
        return $statement;
    }
}

function array_find(array $array, callable $callback) {
    foreach ($array as $item) {
        if (call_user_func($callback, $item)) {
            return $item;
        }
    }
    return null;
}

function average(array $array): float {
    return array_sum($array) / count($array);
}

function smart_round(float $number): float {
    if ($number > 10) {
        return round($number, 4);
    } else {
        return round($number, 8);
    }
}

// #####################################################################################################

define('SAVE_TIMEOUT', 10 * 60); // seconds

class Coin {
    public function __construct(string $symbol, string $name) {
        $this->symbol = $symbol;
        $this->name = $name;

        $this->price = null;
        $this->priceSeconds = [];
        $this->priceMinutes = [];
    }
}

$baseCoin = new Coin('USDT', 'USD Tether');

$coins = [
    new Coin('BTC', 'Bitcoin'),
    new Coin('ETH', 'Ethereum'),
    new Coin('BNB', 'Binance Coin'),
    new Coin('XRP', 'Ripple'),
    new Coin('DOGE', 'Dogecoin'),
    new Coin('ADA', 'Cardano'),
    new Coin('DOT', 'Polkadot'),
    new Coin('LTC', 'Litecoin'),
    new Coin('CAKE', 'PancakeSwap'),
    new Coin('BAKE', 'BakerySwap')
];

// Connect to SQLite database
Database::connect('sqlite:bot.db');

// Create coin prices table
Database::query('CREATE TABLE IF NOT EXISTS `coin_prices` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `symbol` VARCHAR(6) NOT NULL,
    `prices` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
)');

// Event loop
$loop = React\EventLoop\Factory::create();

// Connect to Binance WebSockets price stream
$url = 'wss://stream.binance.com:9443/stream?streams=' . implode('/', array_map(function ($coin) use ($baseCoin) {
    return strtolower($coin->symbol) . strtolower($baseCoin->symbol) . '@aggTrade';
}, $coins));

$connector = new \Ratchet\Client\Connector($loop);
$connector($url)->then(function ($connection) use ($baseCoin, $coins) {
    $connection->on('message', function ($message) use ($baseCoin, $coins) {
        $message = json_decode($message);

        // Find coin and set new price
        $symbol = strtoupper(str_replace(strtolower($baseCoin->symbol) . '@aggTrade', '', $message->stream));
        $coin = array_find($coins, function ($coin) use ($symbol) {
            return $coin->symbol == $symbol;
        });
        if ($coin != null) {
            $coin->price = $message->data->p;
        }
    });
}, function ($error) {
    echo "[ERROR] Could not connect to Binance WebSockets price stream: {$error->getMessage()}\n";
});

// Sample the coins price to seconds buffer
$sampleCoinsPriceSecond = function () use ($coins) {
    echo "[INFO] Sample coin price second...\n";
    foreach ($coins as $coin) {
        if ($coin->price != null) {
            $coin->priceSeconds[] = $coin->price;
        }
    }
};
$loop->addTimer(1 - fmod(microtime(true), 1), function () use ($loop, $sampleCoinsPriceSecond) {
    $sampleCoinsPriceSecond();
    $loop->addPeriodicTimer(1, $sampleCoinsPriceSecond);
});

// Sample price info at the start of every minute
$sampleCoinsPriceMinute = function () use ($coins) {
    echo "[INFO] Sample coin price minute...\n";
    $minuteTime = strtotime(date('Y-m-d H:i'));
    foreach ($coins as $coin) {
        if (count($coin->priceSeconds) > 0) {
            $priceMinute = [
                $minuteTime,
                smart_round(min($coin->priceSeconds)),
                smart_round(average($coin->priceSeconds)),
                smart_round(max($coin->priceSeconds))
            ];

            echo $coin->symbol . ' ' . json_encode($priceMinute) . "\n";

            $coin->priceMinutes[] = $priceMinute;
            $coin->priceSeconds = [];
        }
    }
};
$loop->addTimer(60 - fmod(microtime(true), 60), function () use ($loop, $sampleCoinsPriceMinute) {
    $sampleCoinsPriceMinute();
    $loop->addPeriodicTimer(60, $sampleCoinsPriceMinute);
});

// Save coin price minutes
$saveCoinsPriceMinutes = function () use ($coins) {
    echo "[INFO] Save coin price minutes...\n";
    $saveTime = time() - time() % (SAVE_TIMEOUT * 60);
    foreach ($coins as $coin) {
        if (count($coin->priceMinutes) > 0) {
            Database::query('INSERT INTO `coin_prices` (`symbol`, `prices`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?)',
                $coin->symbol, json_encode($coin->priceMinutes), $saveTime, $saveTime);
            $coin->priceMinutes = [];
        }
    }
};
$loop->addTimer(SAVE_TIMEOUT - fmod(microtime(true), SAVE_TIMEOUT), function () use ($loop, $saveCoinsPriceMinutes) {
    $saveCoinsPriceMinutes();
    $loop->addPeriodicTimer(SAVE_TIMEOUT, $saveCoinsPriceMinutes);
});

$loop->run();
