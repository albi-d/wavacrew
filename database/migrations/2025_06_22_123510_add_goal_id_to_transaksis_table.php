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
        Schema::table('transaksis', function (Blueprint $table) {
            // Tambahkan kolom goal_id sebagai unsignedBigInteger dan nullable
            $table->unsignedBigInteger('goal_id')->nullable()->after('category_id');

            // Tambahkan foreign key constraint
            $table->foreign('goal_id')
                ->references('id')
                ->on('goals')
                ->onDelete('set null'); // Atau 'cascade' sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['goal_id']);

            // Hapus kolom goal_id
            $table->dropColumn('goal_id');
        });
    }
};
