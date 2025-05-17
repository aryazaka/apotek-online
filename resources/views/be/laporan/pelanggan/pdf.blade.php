<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pelanggan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
        }

        .center {
            text-align: center;
        }

        .image-cell img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: 2px auto;
        }
    </style>
</head>

<body>

    <h3 class="center">LAPORAN DATA PELANGGAN</h3>
    <p class="center">Periode: {{ $from }} s.d. {{ $to }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telpon</th>
                <th>Alamat 1</th>
                <th>Alamat 2</th>
                <th>Alamat 3</th>
                <th>Foto Profil</th>
                <th>Foto KTP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama_pelanggan }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->no_telp }}</td>
                <td>
                    {{ $p->alamat1 }}<br>
                    {{ $p->kota1 }}, {{ $p->propinsi1 }}, {{ $p->kodepos1 }}
                </td>

                <td>
                    @if ($p->alamat2)
                    {{ $p->alamat2 }}<br>
                    {{ $p->kota2 }}, {{ $p->propinsi2 }}, {{ $p->kodepos2 }}
                    @endif
                </td>

                <td>
                    @if($p->alamat3)
                    {{ $p->alamat3 }}<br>
                    {{ $p->kota3 }}, {{ $p->propinsi3 }}, {{ $p->kodepos3 }}
                    @endif
                </td>

                @php
                $fotoPath = public_path('storage/foto-pelanggan/' . basename($p->foto));
                $ktpPath = public_path('storage/foto-ktp/' . basename($p->url_ktp));
                @endphp
                
                <td class="image-cell">
                    @if($p->foto && file_exists($fotoPath))
                    <img src="{{ $fotoPath }}" alt="Foto Profil">
                    @else
                    Tidak Ada
                    @endif
                </td>

                <td class="image-cell">
                    @if($p->url_ktp && file_exists($ktpPath))
                    <img src="{{ $ktpPath }}" alt="Foto KTP">
                    @else
                    Tidak Ada
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>