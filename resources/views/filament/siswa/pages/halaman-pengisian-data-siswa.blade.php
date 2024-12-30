<x-filament-panels::page>

    @if ($this->isEmpty)
        <div class="alert alert-danger">
            <strong>Peringatan</strong> Harap lengkapi data diri anda, agar dapat melanjutkan pendaftaran
        </div>
    @endif

    <x-filament-panels::form wire:submit="simpan">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page>
