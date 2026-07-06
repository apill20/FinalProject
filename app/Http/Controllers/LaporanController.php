<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaksi;
use App\Models\Anggota;
use App\Models\Buku;
use Carbon\Carbon;
 
class LaporanController extends Controller
{
        public function index(Request $request)
    {
        $anggotas = Anggota::orderBy('nama')->get();
        $query = Transaksi::with(['anggota', 'buku']);

        // Filter Tanggal Pinjam
        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Anggota
        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        $transaksis = $query->latest()->get();

        // Hitung Total Denda
        $totalDenda = $transaksis->sum(function ($trx) {

            if ($trx->status == 'Dikembalikan') {
                return $trx->denda ?? 0;
            }

            $batas = Carbon::parse($trx->tanggal_kembali)->startOfDay();
            $sekarang = Carbon::now()->startOfDay();

            if ($batas->isPast() && $sekarang->greaterThan($batas)) {
                return $batas->diffInDays($sekarang) * 5000;
            }

            return 0;
        });

        // Summary Statistik
        $summary = [
            'total' => $transaksis->count(),
            'dipinjam' => $transaksis->where('status', 'Dipinjam')->count(),
            'dikembalikan' => $transaksis->where('status', 'Dikembalikan')->count(),
            'total_denda' => $totalDenda,
        ];

        return view('laporan.index', compact(
            'transaksis',
            'summary',
            'anggotas'
        ));
    }

        /**
     * Export laporan ke format PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Transaksi::with(['anggota', 'buku']);

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        $transaksis = $query->latest()->get();

        $totalTransaksi = $transaksis->count();

        $totalDenda = $transaksis->sum(function ($trx) {

            if ($trx->status == 'Dikembalikan') {
                return $trx->denda ?? 0;
            }

            $batas = Carbon::parse($trx->tanggal_kembali)->startOfDay();
            $sekarang = Carbon::now()->startOfDay();

            if ($batas->isPast() && $sekarang->greaterThan($batas)) {
                return $batas->diffInDays($sekarang) * 5000;
            }

            return 0;
        });

        $pdf = Pdf::loadView('transaksi.pdf', compact(
            'transaksis',
            'totalTransaksi',
            'totalDenda'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-transaksi-perpustakaan.pdf');
    }
}