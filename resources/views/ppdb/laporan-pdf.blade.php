<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan SPMB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .header h3 {
            font-size: 16px;
            margin: 5px 0;
            line-height: 1.2;
        }
        .header h4 {
            font-size: 14px;
            margin: 3px 0;
            line-height: 1.2;
        }
        .header h5 {
            font-size: 12px;
            margin: 3px 0 10px 0;
            line-height: 1.2;
        }
        .summary {
            margin: 5px 0 10px 0;
            font-size: 12px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .summary p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 5px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .logo {
            text-align: center;
            margin-bottom: 5px;
        }
        .logo img {
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>LAPORAN SISTEM PENERIMAAN MURID BARU</h3>
        <h4>MA DARUL FALAH SIRAHAN CLUWAK PATI</h4>
        <h5>TAHUN PELAJARAN: {{ $tahunPelajaran }}</h5>
    </div>

    <div class="summary">
        <p>Naik Tingkat: {{ $totalAlumni }}</p>
        <p>Peserta Baru: {{ $totalBaru }}</p>
        <p><strong>Total Semua: {{ $totalSemua }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NISN</th>
                <th width="30%">Nama Siswa</th>
                <th width="15%">Jenis</th>
                <th width="35%">Asal Sekolah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $siswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $siswa->nisn }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->keterangan }}</td>
                    <td>{{ $siswa->asal_sekolah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
