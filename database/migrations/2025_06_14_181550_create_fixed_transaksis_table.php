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
        Schema::create('fixed_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('jenis', ['Pemasukan', 'Pengeluaran']);
            $table->decimal('jumlah', 15, 2);
            $table->string('deskripsi')->nullable();
            $table->enum('frekuensi', ['harian', 'mingguan', 'bulanan'])->default('bulanan');
            $table->date('tanggal_mulai'); // tanggal awal transaksi tetap dimulai
            $table->date('tanggal_berikutnya'); // tanggal kapan transaksi selanjutnya seharusnya dilakukan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_transaksis');
    }
};
