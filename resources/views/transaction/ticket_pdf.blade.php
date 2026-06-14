<div style="text-align: center; font-family: sans-serif; border: 1px solid #000; padding: 20px; width: 300px; margin: auto; background: #333; color: #fff;">
    <h4>SIJA PARKING</h4>
    <p style="font-size: 10px;">Jl. Raya Karadenan No.7, Karaenan, kec. Cibinong, Kabupaten Bogor, Jawa Barat 16111</p>
    <h2 style="margin: 10px 0;">TIKET PARKIR</h2>
    <p><strong>{{ $tx->lokasi->location_name }}</strong></p>
    {{ strtolower($tx->jenisKendaraan->jenis) == 'other' ? 'truck/bus/other' : $tx->jenisKendaraan->jenis }}    <p style="font-size: 12px;">No Tiket: {{ $tx->no_tiket }}</p>
    <p style="font-size: 12px;">Tanggal: {{ $tx->masuk }}</p>
    <p style="font-size: 9px; font-style: italic;">Jangan meninggalkan tiket & barang berharga di kendaraan</p>
</div>