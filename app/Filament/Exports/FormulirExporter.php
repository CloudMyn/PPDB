<?php

namespace App\Filament\Exports;

use App\Models\Formulir;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class FormulirExporter extends Exporter
{
    protected static ?string $model = Formulir::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID')->enabledByDefault(false),
            ExportColumn::make('calon_siswa_id')->enabledByDefault(true),
            ExportColumn::make('nomor_formulir')->enabledByDefault(false),
            ExportColumn::make('foto')->enabledByDefault(false),
            ExportColumn::make('nama_lengkap')->enabledByDefault(true),
            ExportColumn::make('tempat_lahir')->enabledByDefault(false),
            ExportColumn::make('tanggal_lahir')->enabledByDefault(false),
            ExportColumn::make('jenis_kelamin')->enabledByDefault(false),
            ExportColumn::make('agama')->enabledByDefault(false),
            ExportColumn::make('nomor_telepon')->enabledByDefault(false),
            ExportColumn::make('alamat')->enabledByDefault(false),
            ExportColumn::make('anak_ke')->enabledByDefault(false),
            ExportColumn::make('nama_ayah')->enabledByDefault(false),
            ExportColumn::make('pekerjaan_ayah')->enabledByDefault(false),
            ExportColumn::make('nomor_telepon_ayah')->enabledByDefault(false),
            ExportColumn::make('nama_ibu')->enabledByDefault(false),
            ExportColumn::make('pekerjaan_ibu')->enabledByDefault(false),
            ExportColumn::make('nomor_telepon_ibu')->enabledByDefault(false),
            ExportColumn::make('alamat_ortu')->enabledByDefault(false),
            ExportColumn::make('jalur_pendaftaran')->enabledByDefault(true),
            ExportColumn::make('status_pendaftaran')->enabledByDefault(true),
            ExportColumn::make('alasan_penolakan')->enabledByDefault(false),
            ExportColumn::make('score')->enabledByDefault(true),
            ExportColumn::make('created_at')->enabledByDefault(false),
            ExportColumn::make('updated_at')->enabledByDefault(false),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor formulir Anda telah selesai dan ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}
