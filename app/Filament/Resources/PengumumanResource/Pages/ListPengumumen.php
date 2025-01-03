<?php

namespace App\Filament\Resources\PengumumanResource\Pages;

use App\Filament\Imports\PengumumanImporter;
use App\Filament\Resources\PengumumanResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListPengumumen extends ListRecords
{
    protected static string $resource = PengumumanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->label('Buat Pengumuman')
                ->importer(PengumumanImporter::class)
        ];
    }
}
