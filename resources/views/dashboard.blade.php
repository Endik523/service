@extends('layouts.auth')

@section('body')
    <div class="order-list-container">
        <div class="order-list-header">
            <h2 class="order-list-title">Daftar Pesanan Anda</h2>
            <p class="order-list-subtitle">Riwayat semua permintaan service Anda</p>
        </div>

        @if($orders->isEmpty())
            <div class="empty-order-state">
                <i class="fas fa-box-open empty-order-icon"></i>
                <h3 class="empty-order-title">Belum Ada Pesanan</h3>
                <p class="empty-order-text">Anda belum membuat pesanan service</p>
                <a href="{{ route('isi') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i> Buat Pesanan Baru
                </a>
            </div>
        @else
            <div class="order-grid">
                @foreach($orders as $order)
                    <a href="{{ route('status', ['order_id' => $order->id]) }}" class="order-card-link">
                        <div class="order-card">
                            <div class="order-card-header">
                                <span class="order-id">#{{ $order->id_random }}</span>
                                <span class="order-status-badge status-{{ strtolower($order->status ?? 'pending') }}">
                                    {{ $order->status ?? 'Pending' }}
                                </span>
                            </div>

                            <div class="order-card-body">
                                <div class="order-info-item">
                                    <i class="fas fa-user order-info-icon"></i>
                                    <span class="order-info-label">Nama:</span>
                                    <span class="order-info-value">{{ $order->username }}</span>
                                </div>

                                <div class="order-info-item">
                                    <i class="fas fa-laptop order-info-icon"></i>
                                    <span class="order-info-label">Barang:</span>
                                    <span class="order-info-value">{{ $order->barang }}</span>
                                </div>

                                <div class="order-info-item">
                                    <i class="far fa-calendar-alt order-info-icon"></i>
                                    <span class="order-info-label">Tanggal:</span>
                                    <span
                                        class="order-info-value">{{ \Carbon\Carbon::parse($order->tgl_pesan)->format('d M Y') }}</span>
                                </div>

                                <div class="order-info-item">
                                    <i class="fas fa-truck order-info-icon"></i>
                                    <span class="order-info-label">Penjemputan:</span>
                                    <span class="order-info-value">
                                        {{ $order->jemput_barang == 'yes' ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-card-footer">
                                <span class="view-details-text">
                                    Lihat detail pesanan <i class="fas fa-chevron-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
