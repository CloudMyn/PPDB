<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormulirResource\Pages;
use App\Filament\Resources\FormulirResource\RelationManagers;
use App\Filament\Siswa\Pages\HalamanRegistrasiFormulir;
use App\Models\Formulir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormulirResource extends Resource
{
    protected static ?string $model = Formulir::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('calon_siswa_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nomor_formulir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('foto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->required(),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('agama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('anak_ke')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_ayah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan_ayah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_telepon_ayah')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_ibu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan_ibu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_telepon_ibu')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_ortu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_pendaftaran')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calon_siswa_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_formulir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_ortu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pendaftaran'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFormulirs::route('/'),
            'create' => Pages\CreateFormulir::route('/create'),
            'edit' => Pages\EditFormulir::route('/{record}/edit'),
        ];
    }
}
