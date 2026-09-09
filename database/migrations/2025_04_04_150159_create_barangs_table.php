<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('kode_barang')->unique();
            $table->text('barcode')->nullable();
            $table->date('join_date');
            $table->string('full_name');
            $table->string('brand_name');
            $table->text('specification');
            $table->string('fund_source');
            $table->year('year');
            $table->enum('status', ['Baik', 'Rusak']);
            $table->foreignId('bagian_id')->nullable()->constrained('bagian')->onDelete('set null');
            $table->foreignId('ruang_id')->nullable()->constrained('ruang')->onDelete('set null');
            $table->foreignId('lemari_id')->nullable()->constrained('lemari')->onDelete('set null');
            $table->foreignId('rak_id')->nullable()->constrained('rak')->onDelete('set null');
            $table->boolean('is_keluar')->default(false);  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
