<div style="background-color: #f2f2f2; padding: 20px;">
    <div style="background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-family: Arial, sans-serif;">Hallo,</h3>
        <p style="font-family: Arial, sans-serif;">
            {{ $pesan }} <br>
        <table style="text-align: left;">
            <tr>
                <th>Nomor LKHP</th>
                <td>: {{ $no_lkhp }}</td>
            </tr>
            <tr>
                <th>Kantor Cabang</th>
                <td>: {{ $kc }}</td>
            </tr>
            <tr>
                <th>Tanggal Pengembalian</th>
                <td>: {{ $tgl_pengembalian }}</td>
            </tr>
        </table> <br>
        Cek aplikasi berbasis web sekarang untuk meninjau Lembar Konfirmasi Hasil Pemeriksaan (LKHP) tersebut.
        <a href="{{ $url }}">Akses Aplikasi Disini!</a> <br>
        @if ($regard === 'Kepala Kantor' || $regard === 'Pimpinan Cabang')
            <b><i>Note : </i></b> Lembar Konfirmasi ini sudah dikembalikan pada tanggal :<h2
                style="background-color: yellowgreen; color: red;">{{ now()->translatedFormat('d F Y, H:i') . ' WIB' }}
            </h2>
        @else
            <b><i>Note : </i></b> Mohon Lembar Konfirmasi ini agar dikembalikan tanggal :<h2
                style="background-color: yellowgreen; color: red;">{{ $tgl_pengembalian }}</h2>
        @endif
        <br><br>
        <br>

        <b>Regard,</b> <br>
        <b>{{ $regard }}</b> <br>
        <b>PT BPR Kusuma Sumbing</b>
        </p>
    </div>
</div>
