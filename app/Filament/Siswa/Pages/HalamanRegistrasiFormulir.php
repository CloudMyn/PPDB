<?php

namespace App\Filament\Siswa\Pages;

use App\Models\CalonSiswa;
use App\Models\DataJalurAfirmasi;
use App\Models\DataJalurPindahTugas;
use App\Models\DataJalurPrestasi;
use App\Models\DataJalurZonasi;
use App\Models\Formulir;
use Dotswan\MapPicker\Fields\Map;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class HalamanRegistrasiFormulir extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = []; // Variabel untuk menyimpan data form

    protected static string $view = 'filament.siswa.pages.halaman-registrasi-formulir';

    protected static ?string $title = 'Pengisian Formulir';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function canAccess(): bool
    {
        return get_auth_user()->calonSiswa instanceof CalonSiswa && get_auth_user()->calonSiswa->formulir == null;
    }

    public function mount()
    {
        $this->form->fill(
            Formulir::factory()->make()->toArray()
        );
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('submit')
                ->label('Simpan')
                ->submit('submit'),
        ];
    }

    // Metode untuk mendefinisikan form
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Biodata')
                        ->columns(2)
                        ->schema([
                            Forms\Components\FileUpload::make('foto')
                                ->required()
                                ->columnSpanFull()
                                ->image()
                                ->directory('foto_formulir_siswa')
                                ->maxSize(1024 * 5),

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
                    Wizard\Step::make('Data Orang Tua')
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
                    Wizard\Step::make('Pilih Jalur')
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

                            ...$this->jalur(),
                        ]),
                ])
                    ->skippable(true),

            ])
            ->statePath('data'); // Simpan data form ke variabel $data
    }

    // Metode untuk menangani submit form
    public function simpan(): void
    {
        try {
            $data = $this->form->getState(); // Ambil data dari form

            $jalur_data = $data['jalur_data'];


            $jenis_jalur    =   match ($data['jalur_pendaftaran']) {
                'afirmasi' => new DataJalurAfirmasi(),
                'prestasi' => new DataJalurPrestasi(),
                'pindah_tugas' => new DataJalurPindahTugas(),
                'zonasi' => new DataJalurZonasi(),
            };

            DB::beginTransaction();

            $formulir = Formulir::daftar($data);

            $jalur_data['formulir_id'] = $formulir->id;

            // throw new \Exception(json_encode($jalur_data));

            $jenis_jalur->create($jalur_data);

            unset($data['jalur_data']);
            unset($data['location']);

            // Tampilkan notifikasi sukses
            Notification::make()
                ->success()
                ->title('Berhasil!')
                ->body('Formulir berhasil disimpan')
                ->send();

            DB::commit();
        } catch (\Throwable $th) {

            DB::rollBack();

            // Tampilkan notifikasi error
            Notification::make()
                ->danger()
                ->title('Kesalahan!')
                ->body($th->getMessage())
                ->send();
        }
    }

    public function jalur()
    {
        return [
            Fieldset::make('Dokumen Pendukung')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'afirmasi';
                })
                ->schema([
                    Forms\Components\FileUpload::make('jalur_data.file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('jalur_data.file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('jalur_data.jalur_data.file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('jalur_data.file_kip')
                        ->label('Kartu Indonesia Pintar')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    Forms\Components\FileUpload::make('jalur_data.file_sktm')
                        ->label('Surat Keterangan Tidak Mampu')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->columnSpanFull()
                        ->maxSize(1024 * 5)
                        ->directory(fn(): string => 'public/formulir/afirmasi'),

                    ...$this->getMap(),
                ]),


            Forms\Components\Fieldset::make('Data Jalur Zonasi')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'zonasi';
                })
                ->schema([
                    Forms\Components\FileUpload::make('jalur_data.file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/zonasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/zonasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->columnSpanFull()
                        ->directory('public/formulir/zonasi')
                        ->nullable(),

                    ...$this->getMap(),

                ]),

            Forms\Components\Fieldset::make('Data Jalur Prestasi')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'prestasi';
                })
                ->schema([
                    Forms\Components\FileUpload::make('jalur_data.file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_raport')
                        ->label('Raport')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/prestasi')
                        ->nullable(),

                    Forms\Components\Repeater::make('jalur_data.nila_raport')
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

                    Forms\Components\Hidden::make('jalur_data.total_nilai')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Data Jalur Pindah Tugas')
                ->visible(function ($get): bool {
                    return $get('jalur_pendaftaran') === 'pindah_tugas';
                })
                ->schema([
                    Forms\Components\FileUpload::make('jalur_data.file_surat_mutasi_kerja_ortu')
                        ->label('Surat Mutasi Kerja Orang Tua')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_kk')
                        ->label('Kartu Keluarga')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_surat_keterangan_domisili')
                        ->label('Surat Keterangan Domisili')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_akta_kelahiran')
                        ->label('Akta Kelahiran')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    Forms\Components\FileUpload::make('jalur_data.file_ijaza')
                        ->label('Ijaza')
                        ->acceptedFileTypes(['application/pdf', 'application/doc', 'application/docx'])
                        ->maxSize(1024 * 5)
                        ->columnSpanFull()
                        ->directory('public/formulir/pindah_tugas')
                        ->nullable(),

                    ...$this->getMap(),
                ]),

        ];
    }


    protected function getMap()
    {
        return [

            Forms\Components\TextInput::make('jalur_data.koordinat_bujur')
                ->label('Koordinat Bujur')
                ->required(),

            Forms\Components\TextInput::make('jalur_data.koordinat_lintang')
                ->label('Koordinat Lintang')
                ->required(),

            Forms\Components\Hidden::make('jalur_data.jarak')
                ->required(),

            Map::make('location')
                ->label('Location')
                ->columnSpanFull()
                ->defaultLocation(latitude: '-5.126307610718781', longitude: "119.4290051637608")
                ->liveLocation()
                ->afterStateUpdated(function (Set $set, ?array $state): void {

                    $school_lat =   "-2.8244198";
                    $school_lng =   "121.5828331";

                    $set('jalur_data.koordinat_bujur',  $state['lat']);
                    $set('jalur_data.koordinat_lintang', $state['lng']);

                    $set('jalur_data.jarak', hitungJarak($state['lat'], $state['lng'], $school_lat, $school_lng));
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