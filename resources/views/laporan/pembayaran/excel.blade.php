{{-- resources/views/laporan/pembayaran/excel.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; }
        th, td { padding: 5px; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">LAPORAN PEMBAYARAN MA DARUL FALAH</h2>
    <p style="text-align: center;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Jenis Pembayaran</th>
                <th>SPP</th>
                <th>Infaq</th>
                <th>Seragam</th>
                <th>Kitab</th>
                <th>Kolektif</th>
                <th>Total</th>
                <th>Status</th>
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
                    <td>{{ $pembayaran->jenis_pembayaran }}</td>
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

    <p style="text-align: right;">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
</body>
</html>
