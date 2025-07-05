<?php

use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public $appearance = 'light'; // Nilai default

    public function mount()
    {
        // Load dari session/localStorage
        $this->appearance = Session::get('appearance', 'light');
    }

    public function updatedAppearance($value)
    {
        // Simpan ke session
        Session::put('appearance', $value);

        // Dispatch event ke frontend
        $this->dispatch('appearance-updated', appearance: $value);
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Tampilan')" :subheading=" __('Perbarui pengaturan tampilan untuk akun Anda')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>