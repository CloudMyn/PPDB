<?php

namespace App\Filament\Widgets;

use App\Models\Formulir;
use App\Models\Pengumuman;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Pendaftar', Formulir::count() . " orang")
                ->icon('heroicon-s-users'),
            Stat::make('Jumlah Lulus', Pengumuman::where('status', 'LULUS')->count() . " orang")
                ->icon('heroicon-s-users'),
            Stat::make('Jumlah Gagal', Pengumuman::where('status', 'GAGAL')->count() . " orang")
                ->icon('heroicon-s-users'),
        ];
    }
}
