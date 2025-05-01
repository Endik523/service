<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #e0e0e0;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .header p {
            color: #7f8c8d;
            margin: 5px 0 0;
            font-size: 14px;
        }

        .order-info {
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            text-align: right;
        }

        .total-amount {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            color: #2c3e50;
            border: 1px solid #e0e0e0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .items-table th {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: left;
            font-size: 14px;
            color: #555;
            border-bottom: 2px solid #e0e0e0;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            padding-top: 15px;
            border-top: 1px dashed #e0e0e0;
        }

        .thank-you {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .date-time {
            text-align: right;
            font-size: 13px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="header">
            <h1>STRUK PEMBAYARAN</h1>
            <p>Service Otw Computer Gusaha</p>
        </div>

        <div class="date-time">
            {{ date('d/m/Y H:i') }} WIB
        </div>

        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Nomor Pesanan:</span>
                <span class="info-value">#{{ $order->id_random }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">Bayar Cash</span>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
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

        <div class="total-amount">
            TOTAL: Rp {{ number_format($totalBiaya, 0, ',', '.') }}
        </div>

        <div class="footer">
            <div class="thank-you">Terima kasih atas kepercayaan Anda</div>
            <div>Silahkan bawa ke kasir kami untuk melakukan pembayaran</div>
            <div style="margin-top: 10px;">Hubungi kami di: 0823-8444-4812</div>
        </div>
    </div>
</body>

</html>
