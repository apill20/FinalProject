<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Perpustakaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #000; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        .summary { margin-bottom: 20px; }
        .summary p { margin: 0 0 5px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: green; }
        .text-warning { color: darkorange; }
        .footer { text-align: right; margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN TRANSAKSI PERPUSTAKAAN</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>
    </div>

    <div class="summary">
        <p>Total Transaksi : {{ $totalTransaksi }}</p>
        <p>Total Denda : Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Kode TRX</th>
                <th width="15%">Nama Anggota</th>
                <th width="25%">Judul Buku</th>
                <th width="12%">Tgl Pinjam</th>
                <th width="12%">Tgl Kembali</th>
                <th width="10%">Status</th>
                <th width="13%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $trx)
            @php
                // Logika Denda Berjalan
                $nominalDenda = 0;
                if($trx->status == 'Dikembalikan') {
                    $nominalDenda = $trx->denda ?? 0;
                } else {
                    $batas = \Carbon\Carbon::parse($trx->tanggal_kembali)->startOfDay();
                    $sekarang = now()->startOfDay();
                    if ($batas->isPast() && $sekarang->greaterThan($batas)) {
                        $nominalDenda = $batas->diffInDays($sekarang) * 5000;
                    }
                }
            @endphp
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $trx->kode_transaksi }}</td>
                <td>{{ $trx->anggota->nama }}</td>
                <td>{{ $trx->buku->judul }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td class="text-center">
                    @if($trx->status == 'Dikembalikan')
                        {{ \Carbon\Carbon::parse($trx->tanggal_dikembalikan)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">
                    @if($trx->status == 'Dipinjam')
                        <span class="text-warning">Dipinjam</span>
                    @else
                        <span class="text-success">Dikembalikan</span>
                    @endif
                </td>
                <td class="text-right">
                    {{ $nominalDenda > 0 ? 'Rp '.number_format($nominalDenda, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan di-generate otomatis oleh Sistem Perpustakaan.</p>
    </div>

</body>
</html>