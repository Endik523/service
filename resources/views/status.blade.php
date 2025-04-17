@extends('layouts.auth')

@section('body')

    <div style="margin-top: 120px;">
        <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Masalah Kerusakan</h3>
    </div>

    <table class="tablee" style="max-width: 800px; margin: 0 auto;">
        <tbody>
            <tr>
                <td>
                    <!-- Display damage details dynamically -->
                    <p style="margin-bottom: 0px;">{{ $order->masalah_kerusakan ?? 'Deskripsi kerusakan tidak tersedia.' }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 80px;">
        <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Total Biaya</h3>
    </div>

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
                    <td>{{ $detail->id_order }}</td> <!-- Use id_order instead of random_id if needed -->
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

    {{-- <!-- Display Kurir Information -->
    @if ($kurir)
    <div style="margin-top: 50px;">
        <h3 class="text-center mb-4" style="font-weight: bold; font-size: 25px;">Informasi Kurir</h3>
        <table class="tablee" style="width: 100%; max-width: 500px; margin: 0 auto;">
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
    <div class="alert alert-warning text-center">
        Data kurir tidak ditemukan untuk order ini.
    </div>
    @endif --}}

    <div style="text-align: center; margin-top: 20px;">
        <button type="button" class="btn btn-outline-primary" style="width: 250px;">Batalkan Pesanan</button>
        <button type="button" class="btn btn-outline-primary " style="width: 250px;">Lanjutkan Pembayaran</button>
    </div>

@endsection
