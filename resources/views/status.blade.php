{{-- resources/views/status.blade.php --}}

@extends('layouts.auth')

@section('body')

<div class="d-flex justify-content-center fw-bold mt-3 sizefont">
    Pesanan Anda
</div>

<div class="bg-light">
    <div class="container py-5">
        <div class="table-responsive">
            <a href="{{ route('admin.form') }}" type="button" class="btn btn-outline-primary mb-3">Tambah Pesanan</a>

            <table class="table table-bordered table-striped rounded">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID Order</th>
                        <th>Nama</th>
                        <th>Jenis Barang</th>
                        <th>Masalah Kerusakan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->id }}</td> <!-- Menampilkan ID order -->
                        <td>{{ $order->username }}</td> <!-- Menampilkan nama pengguna -->
                        <td>{{ $order->barang }}</td> <!-- Menampilkan jenis barang -->
                        <td>{{ $order->pesan }}</td> <!-- Menampilkan masalah kerusakan -->
                        <td>{{ $order->tgl_pesan }}</td> <!-- Menampilkan tanggal pesan -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($kerusakan->isNotEmpty())
    <div class="d-flex justify-content-center fw-bold mt-5 sizefont">
        Status Detail
    </div>

    <div class="container text-center col-6 mt-3">
        <table class="table table-bordered border-primary">
            <thead>
                <tr>
                    <th style="width: 50px; font-size: 16px;">Kerusakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kerusakan as $item)
                    <tr>
                        <td class="w-100">{{ $item->kerusakan }}</td> <!-- Menampilkan kerusakan -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center fw-bold mt-5 sizefont">
        Total Biaya
    </div>

    <div class="container text-center col-6 mt-3">
        <table class="table table-bordered border-primary fontsize">
            <thead>
                <tr style="width: 50px; font-size: 16px;">
                    <th>Jumlah Barang</th>
                    <th>Jenis Barang</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kerusakan as $item)
                    @if ($item->items->isNotEmpty())
                        @foreach ($item->items as $barang)
                            <tr>
                                <td>{{ $barang->jumlah_item }}</td>
                                <td>{{ $barang->jenis_barang }}</td>
                                <td>{{ number_format($barang->harga, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center text-danger">Tidak ada barang yang terdaftar.</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-warning text-center">Status Belum Tersedia</div>
@endif

@endsection
