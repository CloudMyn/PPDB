<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
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
            Js::make('jspdf', 'https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js'),
            Js::make('html2canvas', 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js'),
            Js::make('jspdf-html2canvas', 'https://cdn.jsdelivr.net/npm/jspdf-html2canvas@latest/dist/jspdf-html2canvas.min.js'),
        ]);

        // LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
        //     $switch
        //         ->locales(['id', 'en']); // also accepts a closure
        // });



        FilamentView::registerRenderHook(
            PanelsRenderHook::TOPBAR_START,
            fn (): string => "<h1 style='font-size: 23px; font-weight: bold'>" . config('app.name') . "</h1>",
        );
    }
}
