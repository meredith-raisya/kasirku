<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    private int $totalBayar = 0;

    public function hitungSubtotal(int $harga, int $jumlah): int
    {
        if ($jumlah <= 0) {
            throw new Exception('Jumlah beli harus lebih dari 0.');
        }

        if ($harga < 0) {
            throw new Exception('Harga produk tidak boleh negatif.');
        }

        return $harga * $jumlah;
    }

    public function hitungTotalBayar(int $subtotal): int
    {
        if ($subtotal < 0) {
            throw new Exception('Subtotal tidak boleh negatif.');
        }

        $this->totalBayar += $subtotal;

        return $this->totalBayar;
    }

    public function kurangiStok(int $produk_id, int $jumlah): void
    {
        $produk = Produk::find($produk_id);

        if (! $produk) {
            throw new Exception('Produk tidak ditemukan.');
        }

        if ($jumlah <= 0) {
            throw new Exception('Jumlah pembelian tidak valid.');
        }

        if ($produk->stok < $jumlah) {
            throw new Exception(
                "Stok '{$produk->nama_produk}' tidak mencukupi. Sisa stok: {$produk->stok}."
            );
        }

        $sisaStok = $produk->stok - $jumlah;

        if ($sisaStok < 0) {
            throw new Exception('Stok tidak boleh menjadi negatif.');
        }

        $produk->stok = $sisaStok;
        $produk->save(); 
    }

    public function create(): View
    {
        $produks = Produk::where('stok', '>', 0)->orderBy('nama_produk')->get();

        $daftarHarga = Produk::pluck('harga', 'id');

        return view('transaksi.create', compact('produks', 'daftarHarga'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'produk_id' => 'required|array|min:1',     
            'produk_id.*' => 'required|integer|exists:produk,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer',       
        ]);

        $idsProduk = $request->produk_id;
        $daftarJumlah = $request->jumlah;

        $this->totalBayar = 0;
        $totalAkhir = 0;

        try {
            DB::transaction(function () use ($idsProduk, $daftarJumlah, &$totalAkhir) {
                $transaksi = Transaksi::create([
                    'tanggal' => now(), 
                    'total_bayar' => 0,     
                ]);

                foreach ($idsProduk as $index => $produkId) {
                    $jumlah = (int) $daftarJumlah[$index];

                    $produk = Produk::findOrFail((int) $produkId);

                    $subtotal = $this->hitungSubtotal($produk->harga, $jumlah);

                    $transaksi->detailTransaksis()->create([
                        'produk_id' => $produk->id,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                    ]);

                    $this->kurangiStok($produk->id, $jumlah);

                    $totalAkhir = $this->hitungTotalBayar($subtotal);
                }

                $transaksi->update(['total_bayar' => $totalAkhir]);
            });
        } catch (Exception $e) {
            return redirect()
                ->route('transaksi.create')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan. Total bayar: Rp '.number_format($totalAkhir, 0, ',', '.'));
    }

    public function index(): View
    {
        $transaksis = Transaksi::with('detailTransaksis.produk')
            ->latest('tanggal')
            ->paginate(10);
        $totalPenjualan = (float) Transaksi::sum('total_bayar');
        $jumlahTransaksi = Transaksi::count();
        $totalUnitTerjual = (int) DB::table('detail_transaksi')->sum('jumlah');

        return view('transaksi.index', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'totalUnitTerjual'
        ));
    }

    public function show(Transaksi $transaksi): View
    {
        $transaksi->load('detailTransaksis.produk');

        return view('transaksi.show', compact('transaksi'));
    }
}
