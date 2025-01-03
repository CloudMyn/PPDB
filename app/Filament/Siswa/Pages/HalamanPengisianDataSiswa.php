<?php

namespace App\Filament\Siswa\Pages;

use App\Models\CalonSiswa;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class HalamanPengisianDataSiswa extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.siswa.pages.halaman-pengisian-data-siswa';

    public ?array $data = []; // Variabel untuk menyimpan data form

    protected static ?string $title = 'Pengisian Data Siswa';

    public $isEmpty = true;

    public function mount()
    {

        $dataSiswa = get_auth_user()->calonSiswa;

        if ($dataSiswa) {
            $this->form->fill($dataSiswa->toArray());
            $this->isEmpty = false;
        } else {

            if (config('app.env') == 'local') {
                $this->form->fill(
                    CalonSiswa::factory()->make()->toArray()
                );
            }
        }
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
                Forms\Components\Fieldset::make('Biodata')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nisn')
                            ->required()
                            ->length(10),

                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->required()
                            ->options([
                                'male' => 'laki-laki',
                                'female' => 'perempuan',
                            ]),
                    ]),

                Forms\Components\Fieldset::make('Informasi Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('alamat')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ]),

            ])
            ->statePath('data'); // Simpan data form ke variabel $data
    }

    // Metode untuk menangani submit form
    public function simpan(): void
    {
        try {

            $data   =   $this->form->getState(); // Ambil data dari form

            $user   =   get_auth_user();

            $calonSiswa =   $user->calonSiswa;

            $checkNisn = CalonSiswa::where('nisn', $data['nisn'])
                ->where('id', '!=', $user->calonSiswa?->id)
                ->first();

            if ($checkNisn) {
                Notification::make()
                    ->danger()
                    ->title('Kesalahan!')
                    ->body('NISN sudah digunakan oleh calon siswa lain')
                    ->send();

                return;
            }

            if (!$calonSiswa) {
                CalonSiswa::daftar($data);
            } else {
                $calonSiswa->update($data);
            }

            Notification::make()
                ->success()
                ->title('Data Berhasil Disimpan')
                ->send();

            // Redirect ke halaman formulir
            $this->redirect(route('filament.siswa.pages.halaman-registrasi-formulir'));
        } catch (\Throwable $th) {

            Notification::make()
                ->danger()
                ->title('Kesalahan!')
                ->body($th->getMessage())
                ->send();
        }
    }
}
