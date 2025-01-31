<?php

namespace App\Filament\Imports;

use App\Models\Pengumuman;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PengumumanImporter extends Importer
{
    protected static ?string $model = Pengumuman::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('calon_siswa_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('jalur_pendaftaran')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status')
                ->label('Status Pengumuman')
                ->requiredMapping()
                ->rules(['required', 'in_array:LULUS,GAGAL']),
        ];
    }

    public function resolveRecord(): ?Pengumuman
    {
        // return Pengumuman::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Pengumuman();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pengumuman import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
