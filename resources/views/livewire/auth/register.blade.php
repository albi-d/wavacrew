<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Menangani permintaan pendaftaran yang masuk.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="max-w-md w-full mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-hidden p-8">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">{{ __('Buat Akun Baru') }}</h2>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Isi formulir berikut untuk membuat akun baru') }}
        </p>
    </div>

    <!-- Status Sesi -->
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form wire:submit="register" class="space-y-6">
        <!-- Nama Lengkap -->
        <div>
            <flux:input wire:model="name" :label="__('Nama Lengkap')" type="text" required autofocus autocomplete="name"
                placeholder="Nama lengkap Anda" class="w-full" />
        </div>

        <!-- Email -->
        <div>
            <flux:input wire:model="email" :label="__('Alamat Email')" type="email" required autocomplete="email"
                placeholder="email@contoh.com" class="w-full" />
        </div>

        <!-- Kata Sandi -->
        <div class="space-y-2">
            <flux:input wire:model="password" :label="__('Kata Sandi')" type="password" required
                autocomplete="new-password" :placeholder="__('Buat kata sandi')" viewable class="w-full" />
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div class="space-y-2">
            <flux:input wire:model="password_confirmation" :label="__('Konfirmasi Kata Sandi')" type="password" required
                autocomplete="new-password" :placeholder="__('Ulangi kata sandi')" viewable class="w-full" />
        </div>

        <!-- Tombol Daftar -->
        <div>
            <flux:button variant="primary" type="submit" class="w-full justify-center py-2.5">
                {{ __('Daftar Sekarang') }}
            </flux:button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Sudah memiliki akun?') }}
        <flux:link :href="route('login')" wire:navigate
            class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">
            {{ __('Masuk di sini') }}
        </flux:link>
    </div>
</div>