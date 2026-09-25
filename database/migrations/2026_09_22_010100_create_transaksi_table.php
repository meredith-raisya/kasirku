<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel `transaksi` (kepala transaksi / header).
     * Satu baris di sini mewakili satu nota penjualan,
     * rincian item-nya disimpan di tabel `detail_transaksi` (relasi hasMany).
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id(); // primary key transaksi

            $table->dateTime('tanggal');      // waktu transaksi dilakukan
            $table->bigInteger('total_bayar'); // total akumulasi seluruh subtotal item

            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi (rollback) dengan menghapus tabel `transaksi`.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
