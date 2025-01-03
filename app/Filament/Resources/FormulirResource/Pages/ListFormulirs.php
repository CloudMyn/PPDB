<?php

namespace App\Filament\Resources\FormulirResource\Pages;

use App\Filament\Exports\FormulirExporter;
use App\Filament\Resources\FormulirResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListFormulirs extends ListRecords
{
    protected static string $resource = FormulirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(FormulirExporter::class)
                ->modifyQueryUsing(fn(\Illuminate\Database\Eloquent\Builder $query) => $query->where('status_pendaftaran', '=', 'berhasil_verifikasi'))
        ];
    }
}
