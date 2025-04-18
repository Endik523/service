@extends('layouts.auth')

@section('body')

    @if (!$order || ($damageDetails->isEmpty() && !$kurir))
        <!-- Jika tidak ada data order, atau jika damageDetails dan kurir kosong -->
        <div class="text-center"
            style="display: flex; justify-content: center; align-items: center; height: 150px; margin-top: 50px; font-size: 20px;">
            <p style="font-weight: bold;">STATUS BELUM TERSEDIA</p>
        </div>
    @else

        <!-- Display Kurir Information -->
        @if ($kurir)
            <div style="margin-top: 100px;">
                <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Informasi Kurir</h3>
                <table class="tablee" style="width: 100%; max-width: 500px; margin: 0 auto;">
                    <tr>
                        <td style="font-weight: bold;">ID:</td>
                        <td>{{ $kurir->order_id }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Nama Kurir:</td>
                        <td>{{ $kurir->name }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Foto:</td>
                        <td><img src="{{ $kurir->photo }}" alt="Foto Kurir" style="width: 100px; height: auto;" /></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Plat Motor:</td>
                        <td>{{ $kurir->plat_motor }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Merk Motor:</td>
                        <td>{{ $kurir->merk_motor }}</td>
                    </tr>
                </table>
            </div>
        @else
            <div class="alert alert-warning text-center mt-5">
                TIDAK MENGGUNAKAN KURIR
            </div>
        @endif

        <!-- Menampilkan Masalah Kerusakan -->
        @if ($order && $order->damageDetails->isNotEmpty())
            <div style="margin-top: 50px;">
                <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Masalah Kerusakan</h3>
                <table class="tablee" style="max-width: 800px; margin: 0 auto;">
                    <tbody>
                        @foreach($order->damageDetails as $damageDetail)
                            <tr>
                                <td>
                                    <p style="margin-bottom: 0px;">
                                        {{ $damageDetail->masalah_kerusakan ?? 'Deskripsi kerusakan tidak tersedia.' }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Menampilkan Total Biaya -->
        @if ($damageDetails->isNotEmpty())
            <div style="margin-top: 50px;">
                <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Total Biaya</h3>
                <table class="tablee" style="width: 100%; max-width: 500px; margin: 0 auto;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID Order</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through the damage details and display each item -->
                        @foreach ($damageDetails as $index => $detail)
                            <tr>
                                <td style="font-weight: bold;">{{ $index + 1 }}</td>
                                <td>{{ $detail->id_order }}</td>
                                <td>{{ $detail->nama_barang }}</td>
                                <td>Rp {{ number_format($detail->harga_barang, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <!-- Display total cost -->
                        <tr>
                            <td style="font-weight: bold;">Total</td>
                            <td colspan="3" style="text-align:right;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning text-center mt-5">
                TOTAL BIAYA BELUM DI HITUNG
            </div>
        @endif

        <div style="text-align: center; margin-top: 20px;">
            <button type="button" class="btn btn-outline-primary" style="width: 250px;">Batalkan Pesanan</button>
            <button type="button" class="btn btn-outline-primary " style="width: 250px;">Lanjutkan Pembayaran</button>
        </div>
    @endif

@endsection