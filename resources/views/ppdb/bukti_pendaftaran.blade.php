<!DOCTYPE html>
<html>

<head>
    <title>Bukti Pendaftaran - {{ $ppdb->nama_siswa }}</title>
    <style>
        @page {
            size: A4;
            margin: 0 60px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 10px;
        }

        .card {
            border: 1px solid #000;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 1.2em;
            margin: 5px 0;
        }

        .header p {
            margin: 3px 0;
            font-size: 0.9em;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .title {
            text-align: center;
            margin: 15px 0;
            font-weight: bold;
            font-size: 1.1em;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
        }

        .photo-cell {
            width: 120px;
            vertical-align: top;
        }

        .photo {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            object-fit: cover;
        }

        .info-cell {
            vertical-align: top;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 35%;
        }

        .footer-cell {
            vertical-align: bottom;
            text-align: right;
            padding-top: 20px;
        }

        .note {
            margin-top: 10px;
            font-size: 0.9em;
            border-top: 1px solid #000;
            padding-top: 15px;
        }

        .note ol {
            padding-left: 20px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        @if($kopBase64)
        <div class="kop-container">
            <img src="{{ $kopBase64 }}" class="kop-surat" alt="Kop Surat" style="width: 90%;">
        </div>
        @endif
    </div>

    <!-- Judul -->
    <div class="title">
        BUKTI PENDAFTARAN PENERIMAAN MURID BARU<br>
        TAHUN PELAJARAN {{ $ppdb->tahunPelajaran->tahun }}
    </div>

    <div class="card">
        <!-- Main Table for Photo (left) and Content (right) -->
        <table class="info-table">
            <tr>
                <td>NISN</td>
                <td>: {{ $ppdb->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Calon Peserta Didik</td>
                <td>: {{ $ppdb->nama_siswa }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $ppdb->alamat }}</td>
            </tr>
            <tr>
                <td>Asal Sekolah/Madrasah</td>
                <td>: {{ $ppdb->asal_sekolah }}</td>
            </tr>
            <tr>
                <td>Waktu & Tgl. Daftar</td>
                <td>: {{ $ppdb->created_at->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Pendaftar</td>
                <td>: {{ $ppdb->jenis_pendaftar == 'alumni' ? 'Naik Tingkat' : 'Peserta Baru' }}</td>
            </tr>
        </table>
        <table class="main-table">
            <!-- Footer Row -->
            <tr>
                <td class="photo-cell">
                    @if($photoBase64)
                    <img src="{{ $photoBase64 }}" class="photo" alt="Foto Siswa" style="margin-left: 40px;">
                    @else
                    <div class="photo">Foto</div>
                    @endif
                </td>
                <td>
                    <img src="spmb.png" alt="SPMB" style="max-width: 150px; height: auto;">
                </td>
                <td style="vertical-align: top; padding-top: 5px;">
                    <p style="margin-right: 150px; margin-top: 10px;">
                        Sirahan, {{ $tanggal }}
                        <br>Panitia SPMB
                    </p>
                </td>
            </tr>
        </table>

        <!-- Catatan -->
        <div class="note">
            <p><strong>Catatan:</strong></p>
            <ol>
                <li>
                    Pendaftar Peserta Baru harus datang tanggal 29 Juni s.d. 6 Juli ke madrasah
                    untuk konfirmasi dan cetak kartu seleksi dengan membawa atau menunjukkan
                    bukti pendaftaran ini.
                </li>
                <li>
                    Pendaftar Naik Tingkat harus datang tanggal 9 Juli ke madrasah untuk
                    konfirmasi dan melihat pengumuman dengan membawa atau menunjukkan
                    bukti pendaftaran ini.
                </li>
            </ol>
            <p>Contact Person: 085728129782 a.n. Muhammad Aziz, M.Ag.</p>
        </div>
    </div>
</body>

</html>
