@extends('layouts.auth')

@section('body')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="status-container">
        @if (!$order || ($damageDetails->isEmpty() && !$kurir))
            <div class="text-center py-5" style="grid-column: 1/-1">
                <div class="alert alert-warning py-4">
                    <h4 class="mb-0">STATUS BELUM TERSEDIA</h4>
                </div>
            </div>
        @else
            <!-- Header Section -->
            <div class="status-header">
                <h2>Status Pesanan Anda</h2>
                <div class="badge processing">
                    <i class="fas fa-sync-alt mr-2"></i>Dalam Proses
                </div>
                <p class="text-muted">ID Pesanan: <strong>{{ $order->id_random ?? $detail->id_order ?? 'N/A' }}</strong></p>
            </div>



            <!-- Left Column -->
            <div class="left-column">
                @if ($kurir)
                    <!-- Improved Courier Information -->
                    <div class="status-card courier-info">
                        <div class="courier-header">
                            <h3><i class="fas fa-user-tie mr-2"></i>Informasi Kurir</h3>
                        </div>

                        <div class="courier-profile">
                            <div class="courier-photo">
                                <img src="{{ $kurir->photo ?? asset('images/default-courier.jpg') }}" alt="Foto Kurir"
                                    class="courier-img" onerror="this.src='{{ asset('images/default-courier.jpg') }}'">
                            </div>

                            <div class="courier-details">
                                <div class="courier-name">{{ $kurir->name }}</div>

                                <div class="courier-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-value">4.7</span>
                                </div>

                                <div class="courier-vehicle">
                                    <i class="fas fa-motorcycle"></i>
                                    <span>{{ $kurir->merk_motor }} ({{ $kurir->plat_motor }})</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <!-- Damage Information -->
                @if ($order)
                    <div class="status-card damage-info">
                        <h3><i class="fas fa-tools mr-2"></i>Detail Kerusakan</h3>
                        <div class="damage-description">
                            <p class="mb-0">{{ $order->masalah_kerusakan ?? 'Deskripsi kerusakan tidak tersedia.' }}</p>
                        </div>
                        @if($order->damage_photos)
                            <h5 class="mt-4 mb-2">Foto Kerusakan:</h5>
                            <div class="damage-photos">
                                @foreach(json_decode($order->damage_photos) as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Foto Kerusakan" class="img-thumbnail"
                                        onclick="openModal('{{ asset('storage/' . $photo) }}')">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Cost Information -->
                @if ($damageDetails->isNotEmpty())
                    <div class="status-card">
                        <h3><i class="fas fa-receipt mr-2"></i>Rincian Biaya</h3>
                        <div class="table-responsive">
                            <table class="responsive-table">
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
                                    <tr class="bg-light">
                                        <td colspan="2" class="text-right font-weight-bold">Total Biaya:</td>
                                        <td class="font-weight-bold text-success">Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn  btn-action" onclick="confirmCancel()">
                            <i class="fas fa-times me-2 "></i>Batalkan Pesanan
                        </button>
                        <button type="button" class="btn btn-primary btn-action" onclick="continuePayment({{ $order->id }})">
                            <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </button>
                    </div>
                    @if($totalBiaya > 0)
                        <div class="action-section" style="grid-column: 1/-1">
                            <div id="pdf-button" class="mt-5 text-center">
                                <p class="text-muted mb-2">Silahkan download invoice untuk pembayaran offline</p>
                                <a href="{{ route('download.pdf', $order->id) }}" class="btn btn-outline-success btn-action">
                                    <i class="fas fa-file-pdf mr-2"></i>Download Invoice
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        @endif
    </div>


    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-jM-DA1x_pvsOaj2c"></script>
    <script>
        // Function to open image modal
        function openModal(imageSrc) {
            $('#modalImage').attr('src', imageSrc);
            $('#imageModal').modal('show');
        }

        // Function to confirm order cancellation
        function confirmCancel() {
            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: "Anda yakin ingin membatalkan pesanan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelOrder();
                }
            });
        }

        // Function to cancel order
        function cancelOrder() {
            // Sembunyikan tombol saat pembatalan dimulai
            $('.btn-action').hide();

            // Tampilkan loading
            $('#orderStatus').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-danger" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Memproses pembatalan...</p>
                    </div>
                `);

            // Simulasi pembatalan
            setTimeout(() => {
                // Sembunyikan semua kartu status
                $('.status-card, .action-section').fadeOut();

                // Tampilkan pesan dibatalkan
                $('#orderStatus').html(`
                        <div class="alert alert-danger text-center py-4">
                            <h4><i class="fas fa-ban mr-2"></i>Pesanan Telah Dibatalkan</h4>
                            <p class="mb-0">ID Pesanan: {{ $order->id_random ?? $detail->id_order ?? 'N/A' }}</p>
                        </div>
                    `);

                // Update badge status
                $('.badge')
                    .removeClass('processing')
                    .addClass('completed')
                    .html('<i class="fas fa-times-circle mr-2"></i>Dibatalkan');
            }, 1500);
        }


        function continuePayment(orderId) {
            $('.loading-spinner').show();
            $('.btn-pay').prop('disabled', true);

            // Simulasi pengiriman ID ke server untuk memproses pembayaran
            $.ajax({
                url: '/process-payment', // URL endpoint untuk memproses pembayaran
                method: 'POST',
                data: {
                    order_id: orderId, // Kirim ID pesanan
                    _token: '{{ csrf_token() }}' // Pastikan untuk mengirimkan token CSRF jika menggunakan Laravel
                },
                success: function (response) {
                    console.log(response);
                    // Handle sukses pembayaran
                    if (response.success) {
                        snap.pay(response.payment_url);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: response.message
                        });
                    }
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal memproses pembayaran. Silakan coba lagi.'
                    });
                },
                complete: function () {
                    $('.loading-spinner').hide();
                    $('.btn-pay').prop('disabled', false);
                }
            });
        }

    </script>
@endsection