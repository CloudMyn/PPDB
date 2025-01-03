<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengumumanResource\Pages;
use App\Filament\Resources\PengumumanResource\RelationManagers;
use App\Models\Pengumuman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return 'Pengumuman';
    }

    public static function getNavigationGroup(): ?string
    {
        return null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Select::make('calon_siswa_id')
                    ->relationship('calonSiswa', 'nisn')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('jalur_pendaftaran')
                    ->required()
                    ->options([
                        'afirmasi' => 'Afirmasi',
                        'prestasi' => 'Prestasi',
                        'pindah_tugas' => 'Pindah Tugas',
                        'zonasi' => 'Zonasi',
                    ]),

                Forms\Components\Select::make('status')
                    ->options([
                        'LULUS' => 'Lulus',
                        'GAGAL' => 'Gagal',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calonSiswa.nisn')
                    ->label('NISN')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jalur_pendaftaran')
                    ->label('Jalur Pendaftaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Kelulusan')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengumumen::route('/'),
            'create' => Pages\CreatePengumuman::route('/create'),
            'edit' => Pages\EditPengumuman::route('/{record}/edit'),
        ];
    }
}
