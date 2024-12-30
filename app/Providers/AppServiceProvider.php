<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
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

        FilamentAsset::register([
            Css::make('custom-style', asset('css/styles.css')), // sknor theme
        ]);

        // LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
        //     $switch
        //         ->locales(['id', 'en']); // also accepts a closure
        // });
    }
}
