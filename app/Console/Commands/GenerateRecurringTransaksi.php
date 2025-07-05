<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRecurringTransaksi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-recurring-transaksi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $recurrings = RecurringTransaksi::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_akhir', '>=', $today)
            ->get();

        foreach ($recurrings as $recurring) {
            $last = Transaksi::where('user_id', $recurring->user_id)
                ->where('category_id', $recurring->category_id)
                ->where('jenis', $recurring->jenis)
                ->whereDate('tanggal', $today)
                ->first();

            if ($last)
                continue; // Jangan duplikat

            // Cek apakah hari ini sesuai frekuensi
            $shouldGenerate = match ($recurring->frekuensi) {
                'harian' => true,
                'mingguan' => $today->diffInWeeks(Carbon::parse($recurring->tanggal_mulai)) % 1 === 0,
                'bulanan' => $today->day === Carbon::parse($recurring->tanggal_mulai)->day,
                default => false,
            };

            if ($shouldGenerate) {
                Transaksi::create([
                    'user_id' => $recurring->user_id,
                    'tanggal' => $today,
                    'category_id' => $recurring->category_id,
                    'jenis' => $recurring->jenis,
                    'jumlah' => $recurring->jumlah,
                    'deskripsi' => $recurring->deskripsi,
                ]);
                $this->info("Transaksi dibuat untuk user {$recurring->user_id}");
            }
        }

        $this->info('Generate transaksi berulang selesai.');
    }
}
