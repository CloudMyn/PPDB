<?php

namespace App\Filament\Siswa\Pages;

use App\Models\CalonSiswa;
use App\Models\DataJalurAfirmasi;
use App\Models\DataJalurPindahTugas;
use App\Models\DataJalurPrestasi;
use App\Models\DataJalurZonasi;
use App\Models\Formulir;
use App\Models\User;
use Dotswan\MapPicker\Fields\Map;
use Faker\Provider\ar_EG\Text;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Infolists\Components\Section;
use Filament\Forms\Set;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HalamanFormulirSiswa extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    public Model $record; // Variabel untuk menyimpan data form

    public string $status_kelulusan = 'tidak';

    protected static string $view = 'filament.siswa.pages.halaman-formulir-siswa';

    protected static ?string $title = 'Kartu Tanda Bukti Pendaftaran';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function canAccess(): bool
    {
        $calonSiswa = get_auth_user()->calonSiswa;

        if ($calonSiswa?->formulir instanceof Formulir) {

            return true;
        }
        return false;
    }

    public function mount()
    {
        $calonSiswa = get_auth_user()->calonSiswa;

        $this->record = $calonSiswa->formulir;

        if ($calonSiswa instanceof CalonSiswa) {

            if ($calonSiswa->pengumuman?->status == 'LULUS') {
                $this->status_kelulusan = 'lulus';
            } else if ($calonSiswa->pengumuman?->status == 'GAGAL') {
                $this->status_kelulusan = 'gagal';
            }
        }
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record) // Ensure $this->record holds the data
            ->schema([
                ImageEntry::make('foto')
                    ->inlineLabel()
                    ->extraAttributes(['class' => 'image-entry'])
                    ->label('Foto'),
                TextEntry::make('nama_lengkap')
                    ->inlineLabel()
                    ->label('Nama Lengkap'),
                TextEntry::make('tempat_lahir')
                    ->inlineLabel()
                    ->label('Tempat Lahir'),
                TextEntry::make('tanggal_lahir')
                    ->inlineLabel()
                    ->label('Tanggal Lahir'),
                TextEntry::make('jenis_kelamin')
                    ->inlineLabel()
                    ->label('Jenis Kelamin'),
            ]);
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
