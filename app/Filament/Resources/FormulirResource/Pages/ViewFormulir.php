<?php

namespace App\Filament\Resources\FormulirResource\Pages;

use App\Filament\Resources\FormulirResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFormulir extends ViewRecord
{
    protected static string $resource = FormulirResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $relation_data = [];

        $jenis_jalur    =   match ($data['jalur_pendaftaran']) {
            'afirmasi' => $this->record->jalurAfirmasi,
            'prestasi' => $this->record->jalurPrestasi,
            'pindah_tugas' => $this->record->jalurPindahTugas,
            'zonasi' => $this->record->jalurZonasi,
        };

        $relation_data = array_merge($data, $jenis_jalur->toArray());

        return $relation_data;
    }
}
