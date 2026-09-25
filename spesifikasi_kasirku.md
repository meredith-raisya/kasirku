# Spesifikasi Program KasirKu

## 1. Deskripsi Aplikasi

**KasirKu** adalah aplikasi kasir berbasis web yang digunakan untuk mengelola data produk dan mencatat transaksi penjualan.

Aplikasi ini memiliki beberapa fungsi utama, yaitu:

- Mengelola data produk.
- Menambahkan produk baru.
- Mengubah data produk.
- Menghapus produk.
- Membuat transaksi penjualan.
- Memilih beberapa produk dalam satu transaksi.
- Menghitung subtotal dan total pembayaran.
- Mengurangi stok produk secara otomatis setelah transaksi.
- Melihat riwayat transaksi.
- Melihat detail setiap transaksi.

Pada saat transaksi disimpan, sistem melakukan validasi terhadap:

- Produk yang dipilih.
- Jumlah pembelian.
- Ketersediaan stok.

Sistem juga menggunakan **database transaction** sehingga apabila terjadi kesalahan saat proses penyimpanan transaksi, perubahan data dapat dibatalkan menggunakan mekanisme **rollback**.

### Teknologi yang Digunakan

| Teknologi | Keterangan |
|---|---|
| Laravel | Framework aplikasi web |
| PHP | Bahasa pemrograman |
| Blade | Template engine Laravel |
| Bootstrap | Framework CSS/UI |
| JavaScript | Interaksi pada sisi client |
| MySQL | Database |

---

## 2. Daftar Fitur

### A. Manajemen Produk

Fitur manajemen produk meliputi:

1. Menampilkan daftar produk.
2. Menambahkan produk.
3. Mengedit produk.
4. Menghapus produk.
5. Memvalidasi nama produk agar tidak sama.
6. Memvalidasi harga agar tidak bernilai negatif.
7. Memvalidasi stok agar tidak bernilai negatif.
8. Menampilkan stok produk.

### B. Transaksi Penjualan

Fitur transaksi penjualan meliputi:

1. Memilih produk yang akan dibeli.
2. Memasukkan jumlah produk.
3. Memilih beberapa produk dalam satu transaksi.
4. Menghitung subtotal setiap produk.
5. Menghitung total pembayaran.
6. Memvalidasi jumlah pembelian minimal 1.
7. Memvalidasi ketersediaan stok.
8. Mengurangi stok secara otomatis setelah transaksi berhasil.
9. Menyimpan data transaksi.
10. Menyimpan detail transaksi.

### C. Riwayat Transaksi

Fitur riwayat transaksi meliputi:

1. Menampilkan daftar transaksi.
2. Menampilkan tanggal transaksi.
3. Menampilkan total pembayaran.
4. Menampilkan jumlah transaksi.
5. Menampilkan total unit produk yang terjual.
6. Melihat detail setiap transaksi.

---

## 3. Struktur Database

KasirKu menggunakan **3 tabel utama**, yaitu:

- `produk`
- `transaksi`
- `detail_transaksi`

### A. Tabel `produk`

| Kolom | Keterangan |
|---|---|
| `id` | ID produk |
| `nama_produk` | Nama produk |
| `harga` | Harga produk |
| `stok` | Jumlah stok produk |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

### B. Tabel `transaksi`

| Kolom | Keterangan |
|---|---|
| `id` | ID transaksi |
| `tanggal` | Tanggal dan waktu transaksi |
| `total_bayar` | Total pembayaran transaksi |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

### C. Tabel `detail_transaksi`

| Kolom | Keterangan |
|---|---|
| `id` | ID detail transaksi |
| `transaksi_id` | ID transaksi |
| `produk_id` | ID produk |
| `jumlah` | Jumlah produk yang dibeli |
| `subtotal` | Harga produk × jumlah |
| `created_at` | Waktu data dibuat |
| `updated_at` | Waktu data diperbarui |

---

## 4. Relasi Database

Relasi antar tabel pada KasirKu adalah sebagai berikut:

```text
produk
   │
   │ 1
   │
   │ banyak
   ▼
detail_transaksi
   ▲
   │ banyak
   │
   │ 1
   │
transaksi
