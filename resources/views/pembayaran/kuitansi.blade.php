<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kuitansi</title>
    <style>
        @page {
            size: A4;
            margin: 10px;
        }

        body {
            font-family: "Courier New", monospace;
            font-size: 9pt;
            margin: 0;
            padding: 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            letter-spacing: 3px;
            margin-top: 0;
            white-space: nowrap;
            font-size: 12pt;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .total-box {
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
            margin-top: 10px;
        }

        .besar {
            font-size: 14pt;
            font-weight: bold;
            padding: 10px;
            background: repeating-linear-gradient(-45deg,
                    #fff,
                    #fff 5px,
                    #ccc 5px,
                    #ccc 10px);
            border: 1px solid #000;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 6pt;
        }

        .cut {
            font-style: italic;
            font-size: 6pt;
            text-align: left;
            margin-top: 10px;
        }

        pre {
            margin: 0;
            white-space: pre-wrap;
            font-family: "Courier New", monospace;
        }

        /* Gaya khusus untuk tabel */
        .kuitansi-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .kuitansi-table td {
            vertical-align: top;
            padding: 0 10px 10px 10px;
        }

        .left-column {
            width: 35%;
            border-right: 1px solid #000;
        }

        .right-column {
            width: 65%;
        }
    </style>
</head>

<body>
    <table class="kuitansi-table">
        <tr>
            <!-- KOLOM KIRI -->
            <td class="left-column">
                <div class="row"><span>{{ $pembayaran->ppdb->no_pendaftaran }}</span></div>
                <br>
                <strong>{{ $pembayaran->ppdb->nama_siswa }}</strong><br>
                <br>Jenis Bayar</br>
                {{--
                <pre>1. Ifq.   300.000
2. Srg.   200.000
3. Syah.  130.000
4. ktb.
5. Kol.         0</pre> --}}
                <div style="font-family: monospace; font-size: 9t; line-height: 1,5; margin: 2px 0;">
                    @php
                    $payments = [
                    'Infaq' => $pembayaran->nominal_infaq,
                    'Seragam' => $pembayaran->nominal_seragam,
                    'Syahriyah' => $pembayaran->nominal_spp,
                    'kitab' => $pembayaran->nominal_kitab,
                    'Kolektif' => $pembayaran->nominal_kolektif
                    ];
                    @endphp

                    @foreach($payments as $code => $amount)
                    <div style="display: flex; justify-content: space-between;">
                        <span>{{ $loop->iteration }}. {{ $code }}</span>
                        <span>{{ number_format($amount, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <p>Ket. :{{ $pembayaran->keterangan }}</p>

                <p><strong>Total bayar</strong></p>
                <div class="total-box">Rp {{ number_format($total, 0, ',', '.') }}</div>
                <p style="text-align: center">Sirahan, {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d/m/Y')
                    }}<br>{{ $pembayaran->petugas->nama }}</p>
                <span style="font-size: 6pt;">{{ $tanggal }}</span>
            </td>

            <!-- KOLOM KANAN -->
            <td class="right-column">
                <br>
                <div class="judul">K U I T A N S I</div>
                <br>
                <span>Nomor : <i>{{ $pembayaran->ppdb->no_pendaftaran }}</i></span><br><br>
                <span>Nama Peserta : <strong><i>{{ $pembayaran->ppdb->nama_siswa }}</i></strong></span><br>
                <span>Alamat :<i>{{ $pembayaran->ppdb->alamat }}</i></span><br><br>
                <span>Guna Membayar:</span><i>{{ $pembayaran->keterangan }}</i>
                {{--
                <pre>
  1. Infaq         Rp300.000
  2. Seragam       Rp200.000
  3. Syahriyah     Rp130.000
  4. Kolektif      Rp0
                </pre> --}}
                <br>
                <div style="margin-left: 20px; width: 100%;">
                    <table style="width: 100%; border-collapse: collapse; line-height: 1.2;">
                        @foreach($jenis_pembayaran as $jenis => $nominal)
                        <tr style="margin: 0; padding: 0;">
                            <!-- <td style="width: 20%; padding: 0; margin: 0; vertical-align: top;">
                                {{ $loop->iteration }}. {{ $jenis }}
                            </td>
                            <td style="width: 40%; text-align: left; padding: 0; margin: 0; vertical-align: top;">
                                Rp{{ number_format($nominal, 0, ',', '.') }}
                            </td> -->
                        </tr>
                        @endforeach
                    </table>
                </div>

                <p><strong>Total bayar</strong></p>
                <div class="besar">Rp {{ number_format($total, 0, ',', '.') }}</div>
                <p style="text-align: right;">
                    Sirahan, {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d/m/Y') }}<br>
                    Petugas, <br>
                    {{ $pembayaran->petugas->nama }}
                </p>
                <div class="footer">
                    <span>PPDB_MASDafa_{{ $pembayaran->ppdb->tahunPelajaran->tahun }}</span>
                    <span>{{ $tanggal }}</span>
                </div>
            </td>
        </tr>
    </table>
    <p class="cut">_potong disini__________________________________________________________</p>
</body>

</html>
