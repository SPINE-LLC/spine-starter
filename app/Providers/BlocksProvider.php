<?php

namespace App\Providers;

use App\Blocks\Supports;
use Illuminate\Support\ServiceProvider;

class BlocksProvider extends ServiceProvider
{
    public function boot(): void
    {
        new Supports()->boot();
    }
}
