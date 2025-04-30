@extends('layouts.auth')

@section('body')

    <div style="margin-top: 120px;">
        <h3 class="text-center mb-4">Daftar Pesanan Anda</h3>

        @if($orders->isEmpty())
            <div class="alert alert-warning text-center">Anda belum memiliki pesanan.</div>
        @else
            <div class="row justify-content-center"> <!-- Menambahkan justify-content-center untuk tengah -->
                @foreach($orders as $order)
                    <div class="col-12 col-md-3 mb-3" style="min-width: 370px">
                        <!-- 1 kolom per baris di perangkat kecil dan 4 kolom per baris di perangkat lebih besar -->
                        <a href="{{ route('status', ['order_id' => $order->id]) }}" class="card-link">
                            <!-- Link menuju status{id_order} -->
                            <div class="card">

                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <p class="mb-4">Status:</p>
                                        <div class="px-2 bg-transparent border border-warning text-center rounded text-warning py-1 ms-auto mb-4"
                                            style="width: 100px; font-size: 12px;">
                                            {{ $order->status ?? 'Pending' }}
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <p class="mb-2">ID-Order:</p>
                                        <p class="text-end ms-auto mb-2"
                                            style=" font-size: 15px; font-weight: bold; color: #bd8b03;">
                                            {{ $order->id_random }}
                                        </p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <p class="mb-2">Nama:</p>
                                        <p class="text-end ms-auto mb-2">{{ $order->username }}</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <p class="mb-2">Barang:</p>
                                        <p class="text-end ms-auto mb-0">{{ $order->barang }}</p>
                                    </div>

                                    {{-- <div class="d-flex align-items-center">
                                        <p class="mb-0">Alamat:</p>
                                        <p class="text-end ms-auto mb-0">{{ $order->alamat }}</p>
                                    </div> --}}

                                    <div class="d-flex align-items-center">
                                        <p class="mb-2">Tanggal Service:</p>
                                        <p class="text-end ms-auto mb-0">{{ $order->tgl_pesan }}</p>
                                    </div>

                                    {{-- <div class="d-flex align-items-center">
                                        <p class="mb-0">Masalah Kerusakan:</p>
                                        <p class="text-end ms-auto mb-0">{{ $order->pesan ?? '-' }}</p>
                                    </div> --}}

                                    <div class="d-flex align-items-center">
                                        <p class="mb-2">Jemput Barang:</p>
                                        <p class="text-end ms-auto mb-0">{{ $order->jemput_barang }}</p>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        @endif
    </div>

@endsection
