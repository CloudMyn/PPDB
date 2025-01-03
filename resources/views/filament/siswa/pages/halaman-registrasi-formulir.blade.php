<x-filament-panels::page>

    @if ($this->alasan_penolakan != null)
        <div class="alert alert-danger">
            <strong>Formulir Anda Ditolak Dengan Alasan : </strong> {!! $this->alasan_penolakan !!}
        </div>
    @endif

    <x-filament-panels::form wire:submit="simpan">

        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </x-filament-panels::form>
</x-filament-panels::page>
