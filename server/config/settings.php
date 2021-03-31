<?php

return [
    // Calculate everything with this coin
    'main_coin_id' => 1, // USDT

    // Default display all money in this coin
    'default_home_coin_id' => 2, // EUR

    // Default is the Binance commision of 0.075% Maker payed in BNB
    'default_commission' => [
        'percent' => 0.075, // %
        'coin_id' => 3 // BNB
    ]
];
