<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel `detail_transaksi` (tabel penghubung).
     * Tabel ini menyimpan rincian item: satu transaksi bisa punya banyak baris detail,
     * dan setiap baris detail merujuk ke satu produk.
     *
     * Relasi:
     *   transaksi 1 --- * detail_transaksi  * --- 1 produk
     */
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();

            // foreignId + constrained => otomatis membuat FOREIGN KEY ke tabel transaksi
            // onDelete('cascade') => jika transaksi dihapus, detailnya ikut dihapus
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');

            // foreign key ke tabel produk, ON DELETE RESTRICT agar produk
            // yang sudah tercatat di riwayat tidak bisa sembarangan dihapus
            $table->foreignId('produk_id')->constrained('produk')->onDelete('restrict');

            $table->integer('jumlah');     // qty pembelian per item
            $table->bigInteger('subtotal'); // hasil hitung: harga * jumlah (disimpan agar riwayat stabil)

            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi (rollback) dengan menghapus tabel `detail_transaksi`.
     * Karena ini tabel anak, ia harus di-drop SEBELUM tabel induknya (transaksi & produk).
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
