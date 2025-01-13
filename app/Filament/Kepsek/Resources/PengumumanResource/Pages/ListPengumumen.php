<?php

namespace App\Filament\Kepsek\Resources\PengumumanResource\Pages;

use App\Filament\Kepsek\Resources\PengumumanResource;
use App\Filament\Kepsek\Resources\PengumumanResource\Widgets\PengumumanOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengumumen extends ListRecords
{
    protected static string $resource = PengumumanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PengumumanOverview::class,
        ];
    }
}
