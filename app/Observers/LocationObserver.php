<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class LocationObserver
{
    public function created(): void
    {
        Cache::forget('locations');
    }

    public function updated(): void
    {
        Cache::forget('locations');
    }

    public function deleted(): void
    {
        Cache::forget('locations');
    }
}
