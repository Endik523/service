<!DOCTYPE html>
<html>

<head>
    <title>Catatan Pembayaran</title>
</head>

<body>
    <h1>Catatan Pembayaran</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total Biaya: Rp {{ number_format($totalBiaya, 0, ',', '.') }}</p>

    <h3>Detail Barang</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($damageDetails as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->nama_barang }}</td>
                    <td>Rp {{ number_format($detail->harga_barang, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>