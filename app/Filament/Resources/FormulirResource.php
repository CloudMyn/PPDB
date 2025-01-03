<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormulirResource\Pages;
use App\Filament\Resources\FormulirResource\RelationManagers;
use App\Filament\Siswa\Pages\HalamanRegistrasiFormulir;
use App\Models\Formulir;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormulirResource extends Resource
{
    protected static ?string $model = Formulir::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Formulir Pendaftaran';
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
            ->schema([
                Fieldset::make('Biodata')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->required()
                            ->columnSpanFull()
                            ->image()
                            ->directory('foto_formulir_siswa')
                            ->maxSize(1024 * 5)
                            ->openable(),

                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->required()
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ]),
                        Forms\Components\Select::make('agama')
                            ->required()
                            ->options([
                                'islam' => 'Islam',
                                'kristen' => 'Kristen',
                                'katolik' => 'Katolik',
                                'hindu' => 'Hindu',
                                'budha' => 'Budha',
                            ]),

                        Forms\Components\TextInput::make('anak_ke')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),

                Fieldset::make('Data Orangtua')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('alamat_ortu')
                            ->label('Alamat Orang Tua')
                            ->minLength(3)
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\Fieldset::make('Informasi Ayah')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama_ayah')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('pekerjaan_ayah')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nomor_telepon_ayah')
                                    ->tel()
                                    ->prefix('+62')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Fieldset::make('Informasi Ibu')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama_ibu')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('pekerjaan_ibu')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nomor_telepon_ibu')
                                    ->tel()
                                    ->prefix('+62')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),

                Fieldset::make('Jalur Pendaftaran')
                    ->columns(1)
                    ->schema([

                        Forms\Components\Select::make('jalur_pendaftaran')
                            ->live()
                            ->options([
                                'afirmasi' => 'Afirmasi',
                                'prestasi' => 'Prestasi',
                                'pindah_tugas' => 'Pindah Tugas',
                                'zonasi' => 'Zonasi',
                            ])
                            ->required(),

                        ...self::jalur()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calonSiswa.nisn')
                    ->label('NISN')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_formulir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jalur_pendaftaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_pendaftaran')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('approve_btn')
                    ->label('Verifikasi')
                    ->requiresConfirmation()
                    ->color('success')
                    ->disabled(function (Formulir $record) {
                        return $record->status_pendaftaran !== 'belum_verifikasi';
                    })
                    ->action(function (Formulir $record, array $data) {

                        $record->update([
                            'status_pendaftaran'    => 'berhasil_verifikasi',
                        ]);

                        Notification::make()
                            ->title('Formuli berhasil diverifikasi')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-check-circle'),

                Tables\Actions\Action::make('reject_btn')
                    ->label('Tolak')
                    ->requiresConfirmation()
                    ->disabled(function (Formulir $record) {
                        return $record->status_pendaftaran !== 'belum_verifikasi';
                    })
                    ->modalWidth('xl')
                    ->form([
                        \Filament\Forms\Components\RichEditor::make('reject_reason')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->label('Alasan Penolakan')
                            ->placeholder('Kenapa Anda menolaknya?')
                            ->required(),
                    ])
                    ->action(function (Formulir $record, array $data) {

                        $record->update([
                            'status_pendaftaran'    => 'gagal_verifikasi',
                            'alasan_penolakan'      => $data['reject_reason'],
                        ]);

                        Notification::make()
                            ->title('Formuli berhasil diverifikasi')
                            ->success()
                            ->send();
                    })
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
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


    public static function jalur()
    {
        return [
            Fieldset::make('Dokumen Pendukung')
                ->relationship('jalurAfirmasi')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'afirmasi';
                })
                ->schema([
                    Forms\Components\FileUpload::make('file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('file_kip')
                        ->label('Kartu Indonesia Pintar')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('file_sktm')
                        ->label('Surat Keterangan Tidak Mampu')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->columnSpanFull()
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    ...self::getMap(),
                ]),


            Forms\Components\Fieldset::make('Data Jalur Zonasi')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'zonasi';
                })
                ->schema([
                    Forms\Components\FileUpload::make('file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/zonasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/zonasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->columnSpanFull()
                        ->directory('public/formulir/zonasi')
                        ->nullable(),

                    ...self::getMap(),

                ]),

            Forms\Components\Fieldset::make('Data Jalur Prestasi')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'prestasi';
                })
                ->schema([
                    Forms\Components\FileUpload::make('file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_raport')
                        ->label('Raport')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\Repeater::make('nila_raport')
                        ->label('Nilai Raport')
                        ->columnSpanFull()
                        ->columns(3)
                        ->schema([
                            Forms\Components\TextInput::make('semester')
                                ->label('Semester')
                                ->required(),

                            Forms\Components\TextInput::make('mata_pelajaran')
                                ->label('Mata Pelajaran')
                                ->required(),

                            Forms\Components\TextInput::make('nilai')
                                ->label('Nilai')
                                ->numeric()
                                ->required(),
                        ]),

                    Forms\Components\Hidden::make('total_nilai')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Data Jalur Pindah Tugas')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'pindah_tugas';
                })
                ->schema([
                    Forms\Components\FileUpload::make('file_surat_mutasi_kerja_ortu')
                        ->label('Surat Mutasi Kerja Orang Tua')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_surat_keterangan_domisili')
                        ->label('Surat Keterangan Domisili')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->openable()
                        ->columnSpanFull()
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    ...self::getMap(),
                ]),

        ];
    }


    protected static function getMap()
    {
        return [

            Forms\Components\TextInput::make('koordinat_bujur')
                ->label('Koordinat Bujur')
                ->required(),

            Forms\Components\TextInput::make('koordinat_lintang')
                ->label('Koordinat Lintang')
                ->required(),

            Forms\Components\Hidden::make('jarak')
                ->required(),

            Map::make('location')
                ->label('Location')
                ->columnSpanFull()
                ->liveLocation()
                ->afterStateUpdated(function (Set $set, ?array $state): void {

                    $school_lat =   "-2.8244198";
                    $school_lng =   "121.5828331";

                    $set('koordinat_bujur',  $state['lat']);
                    $set('koordinat_lintang', $state['lng']);

                    $set('jarak', hitungJarak($state['lat'], $state['lng'], $school_lat, $school_lng));
                })
                ->afterStateHydrated(function ($state, $record, Set $set): void {
                    $set(
                        'location',
                        [
                            'lat'     => $record?->koordinat_bujur,
                            'lng'     => $record?->koordinat_lintang,
                        ]
                    );
                })
                ->extraStyles([
                    'min-height: 60vh',
                    'border-radius: 10px'
                ])
                ->showMarker()
                ->markerColor("#22c55eff")
                ->showFullscreenControl()
                ->showZoomControl()
                ->draggable()
                ->drawMarker()
                ->clickable(true)
                ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                ->zoom(15)
                ->showMyLocationButton()
                ->geoManPosition('topleft')
                ->rotateMode()
                ->setColor('#3388ff')
                ->setFilledColor('#cad9ec')
        ];
    }
}
