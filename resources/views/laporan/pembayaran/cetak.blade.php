<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin-bottom: 5px; }
        .header p { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; text-align: right; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PEMBAYARAN SPMB MA DARUL FALAH</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tgl. Transaksi</th>
                <th>Nama Murid Baru</th>
                <th>Uraian Pembayaran</th>
                <th>Bayar Syahriyah (Rp)</th>
                <th>Bayar Infaq (Rp)</th>
                <th>Bayar Seragam (Rp)</th>
                <th>Bayar Kitab (Rp)</th>
                <th>Bayar Kolektif (Rp)</th>
                <th>Total Bayar (Rp)</th>
                <th>Status Bayar</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $key => $pembayaran)
                @php
                    $total = $pembayaran->nominal_spp + $pembayaran->nominal_infaq +
                             $pembayaran->nominal_seragam + $pembayaran->nominal_kitab +
                             $pembayaran->nominal_kolektif;
                @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $pembayaran->tgl_bayar->format('d/m/Y') }}</td>
                    <td>{{ $pembayaran->ppdb->nama_siswa }}</td>
                    <td>{{ $pembayaran->keterangan }}</td>
                    <td class="text-right">{{ number_format($pembayaran->nominal_spp, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($pembayaran->nominal_infaq, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($pembayaran->nominal_seragam, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($pembayaran->nominal_kitab, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($pembayaran->nominal_kolektif, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($total, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $pembayaran->status }}</td>
                    <td>{{ $pembayaran->petugas->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4">TOTAL</td>
                <td class="text-right">{{ number_format($totalSpp, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalInfaq, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalSeragam, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalKitab, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalKolektif, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalAll, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
