<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();

            // Duplikasi kolom dari tabel barang
            $table->string('full_name');
            $table->string('brand_name')->nullable();
            $table->text('specification')->nullable();
            $table->string('fund_source')->nullable();
            $table->year('year')->nullable();
            $table->date('join_date')->nullable();
            $table->string('kode_barang')->unique();
            $table->string('status')->nullable();
            $table->foreignId('bagian_id')->nullable()->constrained('bagian')->onDelete('set null');
            $table->foreignId('ruang_id')->nullable()->constrained('ruang')->onDelete('set null');

            // Kolom khusus pengeluaran
            $table->date('tanggal_keluar');
            $table->string('tujuan_ruangan');
            $table->string('penerima')->nullable();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
