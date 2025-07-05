<div class="p-6 bg-white dark:bg-neutral-900 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-neutral-800 dark:text-neutral-100 mb-6">Konverter Mata Uang</h2>

    <form wire:submit.prevent="convert" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Input Jumlah -->
            <div class="space-y-2">
                <label for="amount"
                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Jumlah</label>
                <div class="relative rounded-md shadow-sm">
                    <input type="number" wire:model="amount" id="amount" step="any" min="1"
                        class="block w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="0" required>
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                        @if($message == 'The amount must be at least 0.')
                            Jumlah tidak boleh negatif
                        @else
                            {{ $message }}
                        @endif
                    </p>
                @enderror
            </div>

            <!-- Mata Uang Asal -->
            <div class="space-y-2">
                <label for="fromCurrency"
                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Dari</label>
                <div class="relative">
                    <select wire:model="fromCurrency" id="fromCurrency"
                        class="appearance-none block w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer">
                        @foreach($currencies as $code => $name)
                            <option value="{{ $code }}">{{ $code }} - {{ $name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Mata Uang Tujuan -->
            <div class="space-y-2">
                <label for="toCurrency"
                    class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Ke</label>
                <div class="relative">
                    <select wire:model="toCurrency" id="toCurrency"
                        class="appearance-none block w-full px-4 py-2.5 border border-neutral-300 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer">
                        @foreach($currencies as $code => $name)
                            <option value="{{ $code }}">{{ $code }} - {{ $name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Konversi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-1.5" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>

    @if($convertedAmount)
        <div
            class="mt-8 p-5 bg-neutral-50 dark:bg-neutral-800 rounded-xl border border-neutral-200 dark:border-neutral-700 transition-all">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mb-1">Hasil Konversi</p>
                <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                    @if(floor($amount) == $amount)
                        {{ number_format($amount, 0, ',', '.') }} {{ $fromCurrency }} =
                    @else
                        {{ number_format($amount, 2, ',', '.') }} {{ $fromCurrency }} =
                    @endif
                    <span class="text-neutral-800 dark:text-white">
                        @if(floor($convertedAmount) == $convertedAmount)
                            {{ number_format($convertedAmount, 0, ',', '.') }} {{ $toCurrency }}
                        @else
                            {{ number_format($convertedAmount, 2, ',', '.') }} {{ $toCurrency }}
                        @endif
                    </span>
                </h3>
                <div class="mt-3 text-xs text-neutral-500 dark:text-neutral-400">
                    <p>1 {{ $fromCurrency }} =
                        @if(floor($convertedAmount / $amount) == $convertedAmount / $amount)
                            {{ number_format($convertedAmount / $amount, 0, ',', '.') }}
                        @else
                            {{ number_format($convertedAmount / $amount, 6, ',', '.') }}
                        @endif
                        {{ $toCurrency }}
                    </p>
                    <p>1 {{ $toCurrency }} =
                        @if(floor($amount / $convertedAmount) == $amount / $convertedAmount)
                            {{ number_format($amount / $convertedAmount, 0, ',', '.') }}
                        @else
                            {{ number_format($amount / $convertedAmount, 6, ',', '.') }}
                        @endif
                        {{ $fromCurrency }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($error)
        <div
            class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-600 dark:text-red-300 text-sm transition-all">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span>
                    @if($error == 'The amount must be at least 0.')
                        Jumlah tidak boleh negatif
                    @else
                        {{ $error }}
                    @endif
                </span>
            </div>
        </div>
    @endif
</div>