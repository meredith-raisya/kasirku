# SPESIFIKASI PROGRAM KASIRKU

## 1. Deskripsi Aplikasi

KasirKu adalah aplikasi kasir berbasis web yang digunakan untuk mengelola data produk dan mencatat transaksi penjualan.

Aplikasi ini memiliki beberapa fungsi utama, yaitu:

- Mengelola data produk.
- Menambahkan produk baru.
- Mengubah data produk.
- Menghapus produk.
- Membuat transaksi penjualan.
- Memilih beberapa produk dalam satu transaksi.
- Menghitung subtotal dan total pembayaran.
- Mengurangi stok produk secara otomatis setelah transaksi berhasil.
- Melihat riwayat transaksi.
- Melihat detail setiap transaksi.

Pada saat transaksi disimpan, sistem melakukan validasi terhadap produk, jumlah pembelian, dan ketersediaan stok.

Sistem juga menggunakan **database transaction**. Apabila terjadi kesalahan saat proses penyimpanan transaksi, perubahan data dapat dibatalkan atau dilakukan **rollback**, sehingga data tidak tersimpan dalam kondisi yang tidak sesuai.

### Teknologi yang Digunakan

| Teknologi | Keterangan |
|---|---|
| Laravel | Framework untuk membangun aplikasi web |
| PHP | Bahasa pemrograman yang digunakan |
| Blade | Template engine Laravel untuk membuat tampilan |
| Bootstrap | Framework CSS untuk membuat tampilan antarmuka |
| JavaScript | Digunakan untuk interaksi pada sisi client |
| MySQL | Database untuk menyimpan data aplikasi |

---

## 2. Daftar Fitur

### A. Manajemen Produk

1. Menampilkan daftar produk.
2. Menambahkan produk baru.
3. Mengedit data produk.
4. Menghapus produk.
5. Melakukan validasi agar nama produk tidak sama.
6. Melakukan validasi harga agar tidak bernilai negatif.
7. Melakukan validasi stok agar tidak bernilai negatif.
8. Menampilkan jumlah stok setiap produk.

### B. Transaksi Penjualan

1. Memilih produk yang akan dibeli.
2. Memasukkan jumlah produk yang dibeli.
3. Memilih beberapa produk dalam satu transaksi.
4. Menghitung subtotal setiap produk.
5. Menghitung total pembayaran.
6. Memvalidasi jumlah pembelian minimal 1.
7. Memvalidasi ketersediaan stok produk.
8. Mengurangi stok secara otomatis setelah transaksi berhasil.
9. Menyimpan data transaksi.
10. Menyimpan detail transaksi.

### C. Riwayat Transaksi

1. Menampilkan daftar transaksi.
2. Menampilkan tanggal transaksi.
3. Menampilkan total pembayaran.
4. Menampilkan jumlah transaksi.
5. Menampilkan total unit produk yang terjual.
6. Melihat detail setiap transaksi.

---

## 3. Struktur Database

KasirKu menggunakan tiga tabel utama, yaitu **produk**, **transaksi**, dan **detail_transaksi**.

### A. Tabel Produk

| Kolom | Keterangan |
|---|---|
| id | ID produk |
| nama_produk | Nama produk |
| harga | Harga produk |
| stok | Jumlah stok produk |
| created_at | Waktu data dibuat |
| updated_at | Waktu data diperbarui |

### B. Tabel Transaksi

| Kolom | Keterangan |
|---|---|
| id | ID transaksi |
| tanggal | Tanggal dan waktu transaksi |
| total_bayar | Total pembayaran transaksi |
| created_at | Waktu data dibuat |
| updated_at | Waktu data diperbarui |

### C. Tabel Detail Transaksi

| Kolom | Keterangan |
|---|---|
| id | ID detail transaksi |
| transaksi_id | ID transaksi |
| produk_id | ID produk |
| jumlah | Jumlah produk yang dibeli |
| subtotal | Harga produk × jumlah |
| created_at | Waktu data dibuat |
| updated_at | Waktu data diperbarui |

### Relasi Database

Relasi antar tabel pada aplikasi KasirKu adalah:

- **1 Produk** dapat muncul pada banyak **DetailTransaksi**.
- **1 Transaksi** dapat memiliki banyak **DetailTransaksi**.
- **1 DetailTransaksi** hanya terkait dengan **1 Produk**.
- **1 DetailTransaksi** hanya terkait dengan **1 Transaksi**.

Secara sederhana:

```text
produk
   |
   | 1
   |
   | banyak
   v
detail_transaksi
   ^
   | banyak
   |
   | 1
   |
transaksi
```

---

## 4. Route yang Digunakan

### A. Route Produk

| Method | Route | Fungsi |
|---|---|---|
| GET | `/produk` | Menampilkan daftar produk |
| GET | `/produk/create` | Menampilkan form tambah produk |
| POST | `/produk` | Menyimpan produk baru |
| GET | `/produk/{produk}/edit` | Menampilkan form edit produk |
| PUT | `/produk/{produk}` | Memperbarui data produk |
| DELETE | `/produk/{produk}` | Menghapus produk |

### B. Route Transaksi

| Method | Route | Fungsi |
|---|---|---|
| GET | `/transaksi/create` | Menampilkan form transaksi |
| POST | `/transaksi` | Menyimpan transaksi |
| GET | `/transaksi` | Menampilkan riwayat transaksi |
| GET | `/transaksi/{transaksi}` | Menampilkan detail transaksi |

---

## 5. Flowchart Sederhana Alur Transaksi

```text
                MULAI
                  ↓
            Pilih Produk
                  ↓
        Masukkan Jumlah Beli
                  ↓
            Cek Stok Produk
                  ↓
             Stok Cukup?
              /       \
           TIDAK       YA
             ↓          ↓
      Tampilkan Error   Hitung Subtotal
             ↓          ↓
           SELESAI   Kurangi Stok
                        ↓
                 Simpan Transaksi
                        ↓
                 Hitung Total Bayar
                        ↓
                 Tampilkan Transaksi
                        ↓
                     SELESAI
```

### Penjelasan Singkat Alur Transaksi

1. Pengguna memilih produk yang akan dibeli.
2. Pengguna memasukkan jumlah produk yang ingin dibeli.
3. Sistem mengecek ketersediaan stok produk.
4. Jika stok tidak mencukupi, sistem menampilkan pesan error dan proses selesai.
5. Jika stok mencukupi, sistem menghitung subtotal berdasarkan harga produk dan jumlah pembelian.
6. Sistem mengurangi stok produk sesuai jumlah yang dibeli.
7. Sistem menyimpan data transaksi dan detail transaksi.
8. Sistem menghitung total pembayaran.
9. Sistem menampilkan hasil transaksi.
10. Proses transaksi selesai.