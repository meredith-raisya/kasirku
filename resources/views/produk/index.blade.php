{{-- Fitur 1: Menampilkan daftar produk (nama, harga, stok) --}}
@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Daftar Produk</h4>
            <small class="text-muted">Master data barang yang dijual</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('transaksi.create') }}" class="btn btn-outline-primary">Buat Transaksi</a>
            <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
        </div>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th class="text-end">Harga (Rp)</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $produk)
                        <tr>
                            <td>{{ $produk->id }}</td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td class="text-end harga">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $produk->stok }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('produk.edit', $produk) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus produk {{ $produk->nama_produk }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada produk. Tambahkan dulu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $produks->links('pagination::bootstrap-5') }}</div>
    </div>
@endsection
