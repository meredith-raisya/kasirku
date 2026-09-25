<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $daftarProduk = [
            ['nama_produk' => 'Indomie Goreng',    'harga' => 3500,  'stok' => 120],
            ['nama_produk' => 'Aqua 600ml',        'harga' => 4000,  'stok' => 80],
            ['nama_produk' => 'Teh Pucuk 350ml',   'harga' => 5000,  'stok' => 60],
            ['nama_produk' => 'Beras 5kg',         'harga' => 65000, 'stok' => 25],
            ['nama_produk' => 'Minyak Goreng 1L',  'harga' => 18000, 'stok' => 40],
            ['nama_produk' => 'Gula Pasir 1kg',    'harga' => 15500, 'stok' => 35],
            ['nama_produk' => 'Kopi Kapal Api 165g', 'harga' => 9500, 'stok' => 50],
            ['nama_produk' => 'Sabun Lifebuoy',    'harga' => 3800,  'stok' => 0],   // contoh stok habis
        ];

        foreach ($daftarProduk as $produk) {
            Produk::firstOrCreate(['nama_produk' => $produk['nama_produk']], $produk);
        }
    }
}
