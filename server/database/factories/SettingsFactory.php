<?php

namespace Database\Factories;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class SettingsFactory extends Factory
{
    protected $model = Settings::class;

    public function definition()
    {
        return [
            'home_coin_id' => config('settings.default_home_coin_id'),
            'default_commission_coin_id' => config('settings.default_commission.coin_id'),
            'default_commission_percent' => config('settings.default_commission.percent')
        ];
    }
}
