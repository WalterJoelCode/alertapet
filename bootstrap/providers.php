<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use Laravel\Boost\BoostServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    BoostServiceProvider::class,
];
