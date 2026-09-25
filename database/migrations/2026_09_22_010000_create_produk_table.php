<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel `produk`.
     * Tabel ini adalah master data (tabel induk) yang akan direlasikan
     * ke tabel detail_transaksi melalui relasi hasMany.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // primary key otomatis (unsignedBigInteger auto increment)

            $table->string('nama_produk'); // nama barang yang dijual
            $table->bigInteger('harga');   // bigInteger agar aman untuk harga besar (rupiah)
            $table->integer('stok');       // jumlah persediaan barang

            $table->timestamps(); // membuat kolom created_at & updated_at otomatis
        });
    }

    /**
     * Membalikkan migrasi (rollback) dengan menghapus tabel `produk`.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
