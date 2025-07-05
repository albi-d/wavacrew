<div class="mt-4">
    <h2 class="text-lg font-bold mb-2">Daftar Transaksi</h2>
    <ul class="space-y-2">
        @forelse($transaksis as $trx)
            <li class="border p-3 rounded bg-gray-100">
                <div class="flex justify-between">
                    <span>{{ $trx->tanggal }} | {{ $trx->kategori }} | <strong
                            class="{{ $trx->jenis == 'pengeluaran' ? 'text-red-600' : 'text-green-600' }}">{{ number_format($trx->jumlah, 0, ',', '.') }}</strong></span>
                    <span class="text-sm">{{ $trx->jenis }}</span>
                </div>
                @if ($trx->deskripsi)
                    <div class="text-sm text-gray-500 mt-1">{{ $trx->deskripsi }}</div>
                @endif
            </li>
        @empty
            <li class="text-gray-500">Belum ada transaksi</li>
        @endforelse
    </ul>
</div>