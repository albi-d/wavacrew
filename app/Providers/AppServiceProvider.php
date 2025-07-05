<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);

        // Set timezone konsisten
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');

        // Untuk memastikan Carbon menggunakan timezone yang benar
        Carbon::setLocale(config('app.locale'));
        Carbon::setToStringFormat('Y-m-d H:i:s');
    }
}
