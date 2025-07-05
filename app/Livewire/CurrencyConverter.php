<?php

namespace App\Livewire;

use App\Models\CurrencyHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CurrencyConverter extends Component
{
    public $fromCurrency = 'USD';
    public $toCurrency = 'IDR';
    public $amount = 1;
    public $convertedAmount;
    public $currencies = [];
    public $error;

    public function mount()
    {
        try {
            $response = Http::get('https://api.frankfurter.app/currencies');

            if ($response->successful()) {
                $this->currencies = $response->json(); // ['USD' => 'United States Dollar', ...]
            } else {
                $this->error = 'Gagal mengambil daftar mata uang.';
                $this->currencies = [
                    'USD' => 'United States Dollar',
                    'IDR' => 'Indonesian Rupiah',
                    'EUR' => 'Euro'
                ];
            }
        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->currencies = [
                'USD' => 'United States Dollar',
                'IDR' => 'Indonesian Rupiah',
                'EUR' => 'Euro'
            ];
        }
    }

    public function convert()
    {
        $this->validate([
            'fromCurrency' => 'required|string|size:3',
            'toCurrency' => 'required|string|size:3',
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            $response = Http::get('https://api.frankfurter.app/latest', [
                'amount' => $this->amount,
                'from' => strtoupper($this->fromCurrency),
                'to' => strtoupper($this->toCurrency)
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->convertedAmount = $data['rates'][$this->toCurrency];
                $this->error = null;

                CurrencyHistory::create([
                    'user_id' => Auth::id(),
                    'from_currency' => $this->fromCurrency,
                    'to_currency' => $this->toCurrency,
                    'amount' => $this->amount,
                    'converted_amount' => $this->convertedAmount,
                    'converted_at' => now(),
                ]);

                $this->dispatch('history-updated');
            } else {
                $this->convertedAmount = null;
                $this->error = 'Gagal mendapatkan data konversi.';
            }
        } catch (\Exception $e) {
            $this->convertedAmount = null;
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.currency-converter');
    }
}
