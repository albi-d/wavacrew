<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fixed_transaksis', function (Blueprint $table) {
            $table->dateTime('terakhir_dilakukan')
                ->nullable()
                ->after('tanggal_berikutnya')
                ->comment('Tanggal terakhir transaksi ini dilakukan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixed_transaksis', function (Blueprint $table) {
            $table->dropColumn('terakhir_dilakukan');
        });
    }
};
