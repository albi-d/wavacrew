<?php

use App\Enums\UserRole;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Menangani permintaan autentikasi masuk.
     */
    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        if (auth()->user()->role === UserRole::Admin) {
            return redirect()->route("admin.dashboard")->with("success", "Berhasil masuk.");
        }

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Memastikan permintaan autentikasi tidak dibatasi rate limit.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Mendapatkan kunci throttle untuk pembatasan rate autentikasi.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div class="max-w-md w-full mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-hidden p-8">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">{{ __('Masuk ke akun Anda') }}</h2>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Masukkan email dan kata sandi Anda di bawah ini untuk masuk') }}
        </p>
    </div>

    <!-- Status Sesi -->
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email -->
        <div>
            <flux:input wire:model="email" :label="__('Alamat Email')" type="email" required autofocus
                autocomplete="email" placeholder="email@contoh.com" class="w-full" />
        </div>

        <!-- Kata Sandi -->
        <div class="space-y-2">
            <div class="relative">
                <flux:input wire:model="password" :label="__('Kata Sandi')" type="password" required
                    autocomplete="current-password" :placeholder="__('Kata Sandi')" viewable class="w-full" />
            </div>

            @if (Route::has('password.request'))
                <div class="text-right">
                    <flux:link class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-500"
                        :href="route('password.request')" wire:navigate>
                        {{ __('Lupa kata sandi?') }}
                    </flux:link>
                </div>
            @endif
        </div>

        <!-- Ingat Saya -->
        <div class="flex items-center justify-between">
            <flux:checkbox wire:model="remember" :label="__('Ingat saya')" />
        </div>

        <div>
            <flux:button variant="primary" type="submit" class="w-full justify-center py-2.5">
                {{ __('Masuk') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="mt-6 text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Belum punya akun?') }}
            <flux:link :href="route('register')" wire:navigate
                class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">
                {{ __('Daftar') }}
            </flux:link>
        </div>
    @endif
</div>