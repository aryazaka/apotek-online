<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-size: 16px;">
                <strong>LAPORAN DATA PELANGGAN</strong>
            </th>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;">
                Periode: {{ $from }} s.d. {{ $to }}
            </td>
        </tr>
        <tr></tr>
        <tr style="background-color: #d9d9d9; font-weight: bold;">
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Email</th>
            <th>No. Telepon</th>
            <th>Alamat 1</th>
            <th>Alamat 2</th>
            <th>Alamat 3</th>
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
                @if ($p->alamat3)
                {{ $p->alamat3 }}<br>
                {{ $p->kota3 }}, {{ $p->propinsi3 }}, {{ $p->kodepos3 }}
                @endif
             
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
