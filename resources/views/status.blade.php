@extends('layouts.auth')

@section('body')
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

            <!-- Tracking Card (Full Width) -->
            @if ($kurir)
                <div class="status-card tracking-card">
                    <h3><i class="fas fa-map-marked-alt mr-2"></i>Pelacakan Kurir</h3>

                    <div class="map-container">
                        <div id="courierMap"></div>
                        <div class="map-overlay">
                            <div class="eta-display">
                                <span class="eta-label">Perkiraan Tiba</span>
                                <div id="etaTime">15-20 menit</div>
                            </div>
                        </div>
                    </div>

                    <div class="tracking-info">
                        <div class="tracking-item">
                            <i class="fas fa-road"></i>
                            <div class="tracking-value" id="distanceText">4.2 km</div>
                            <div class="tracking-label">Jarak Tempuh</div>
                        </div>
                        <div class="tracking-item">
                            <i class="fas fa-clock"></i>
                            <div class="tracking-value" id="durationText">~15 menit</div>
                            <div class="tracking-label">Waktu Tempuh</div>
                        </div>
                        <div class="tracking-item">
                            <i class="fas fa-route"></i>
                            <div class="tracking-value" id="routeType">Rute Tercepat</div>
                            <div class="tracking-label">Jenis Rute</div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        {{-- <button id="alternateRoute" class="btn btn-outline-primary">
                            <i class="fas fa-route mr-1"></i>Rute Alternatif
                        </button> --}}
                        <button class="btn btn-outline-success">
                            <i class="fas fa-phone mr-1"></i>Hubungi Kurir
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-share-alt mr-1"></i>Bagikan Lokasi
                        </button>
                    </div>
                </div>
            @endif

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

                                <div class="courier-contact">
                                    <i class="fas fa-phone">NO Hp</i>
                                    <a href="tel:{{ $kurir->phone }}">{{ $kurir->phone }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="status-timeline">
                        <h4><i class="fas fa-clipboard-list mr-2"></i>Status Pengantaran</h4>
                        <div class="steps">
                            <div class="step completed">
                                <i class="fas fa-check-circle"></i>
                                <div class="step-content">
                                    <span>Pesanan Diterima</span>
                                    <small>10:00 WIB</small>
                                </div>
                            </div>
                            <div class="step completed">
                                <i class="fas fa-check-circle"></i>
                                <div class="step-content">
                                    <span>Kurir Menuju Lokasi</span>
                                    <small>10:15 WIB</small>
                                </div>
                            </div>
                            <div class="step active">
                                <i class="fas fa-motorcycle"></i>
                                <div class="step-content">
                                    <span>Dalam Perjalanan</span>
                                    <small>Estimasi 15-20 menit</small>
                                </div>
                            </div>
                            <div class="step">
                                <i class="far fa-clock"></i>
                                <div class="step-content">
                                    <span>Sampai di Tujuan</span>
                                    <small>-</small>
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
                        <button type="button" class="btn btn-cancel btn-action" onclick="confirmCancel()">
                            <i class="fas fa-times mr-2"></i>Batalkan Pesanan
                        </button>
                        <button type="button" class="btn btn-pay btn-action" onclick="continuePayment()">
                            <i class="fas fa-credit-card mr-2"></i>Bayar Sekarang
                            <span class="loading-spinner spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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

            <!-- Action Buttons (Full Width) -->


            <!-- Status Message Area -->
            <div id="orderStatus" class="mt-4" style="grid-column: 1/-1"></div>
        @endif
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" style="max-width: 100%; max-height: 80vh;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


@endsection

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
        // Show loading state
        $('#orderStatus').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Memproses pembatalan...</p>
                </div>
            `);

        // Simulate API call
        setTimeout(() => {
            // Hide all sections
            $('.status-card, .action-section').fadeOut();

            // Show cancellation message
            $('#orderStatus').html(`
                    <div class="alert alert-danger text-center py-4">
                        <h4><i class="fas fa-ban mr-2"></i>Pesanan Telah Dibatalkan</h4>
                        <p class="mb-0">ID Pesanan: {{ $order->id_random ?? $detail->id_order ?? 'N/A' }}</p>
                    </div>
                `);

            // Update status badge
            $('.badge')
                .removeClass('processing')
                .addClass('completed')
                .html('<i class="fas fa-times-circle mr-2"></i>Dibatalkan');
        }, 1500);
    }

    // Function to continue to payment
    function continuePayment() {
        $('.loading-spinner').show();
        $('.btn-pay').prop('disabled', true);

        // Simulate processing
        setTimeout(() => {
            window.location.href = "https://mitrans.com/payment";
        }, 1000);
    }

    // Initialize map when document is ready
    $(document).ready(function () {
        initMap();
        $('[data-toggle="tooltip"]').tooltip();
    });

    function initMap() {
        // Koordinat tengah Surabaya (-7.2575, 112.7521)
        const surabayaCenter = [-7.2575, 112.7521];

        // Inisialisasi peta dengan view Surabaya
        const map = L.map('courierMap').setView(surabayaCenter, 13);

        // Batasi viewport hanya untuk wilayah Surabaya
        const surabayaBounds = L.latLngBounds(
            L.latLng(-7.35, 112.45), // Barat Laut
            L.latLng(-7.10, 112.90)  // Tenggara
        );

        // Set batas maksimal viewport
        map.setMaxBounds(surabayaBounds);

        // Tambahkan tile layer (peta dasar)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
            minZoom: 11  // Zoom minimal agar tidak terlalu jauh
        }).addTo(map);

        // Tambahkan marker untuk lokasi user (contoh: Mall Tunjungan Plaza)
        const userLocation = [-7.2596, 112.7378];
        const userMarker = L.marker(userLocation, {
            icon: L.divIcon({
                html: '<i class="fas fa-map-marker-alt fa-2x" style="color: #3490dc;"></i>',
                iconSize: [30, 30],
                className: 'my-html-icon'
            })
        }).addTo(map).bindPopup("<b>Lokasi Anda</b><br>Mall Tunjungan Plaza");

        // Simulasi rute kurir dari Barat Surabaya ke lokasi user
        const courierPath = [
            [-7.2750, 112.7460], // Barat Surabaya (contoh: daerah Keputih)
            [-7.2700, 112.7480], // Bergerak ke timur
            [-7.2675, 112.7520], // Dekat Jembatan Suramadu
            [-7.2596, 112.7378]  // Tujuan akhir (Tunjungan Plaza)
        ];

        // Tambahkan marker kurir
        const courierMarker = L.marker(courierPath[0], {
            icon: L.divIcon({
                html: '<i class="fas fa-motorcycle fa-2x" style="color: #e74c3c;"></i>',
                iconSize: [30, 30],
                className: 'my-html-icon'
            })
        }).addTo(map).bindPopup("<b>Kurir Anda</b>");

        // Gambar garis rute
        const routeLine = L.polyline(courierPath, {
            color: '#e74c3c',
            weight: 5,
            dashArray: '10, 10',
            opacity: 0.7
        }).addTo(map);

        // Animasi pergerakan kurir
        let currentPoint = 0;
        const moveInterval = setInterval(() => {
            if (currentPoint < courierPath.length - 1) {
                currentPoint++;
                courierMarker.setLatLng(courierPath[currentPoint]);

                // Update ETA
                const remainingPoints = courierPath.length - currentPoint - 1;
                const etaMinutes = remainingPoints * 3;
                $('#etaTime').text(etaMinutes + " menit");

                // Update jarak
                const remainingDistance = (remainingPoints * 1.5).toFixed(1);
                $('#distanceText').text(remainingDistance + " km");

                if (remainingPoints < 2) {
                    $('#routeType').text("Hampir Sampai");
                }
            } else {
                clearInterval(moveInterval);
                $('#etaTime').text("Sudah Sampai");
                $('#distanceText').text("0 km");
                $('.step.active').next().addClass('completed').removeClass('active');
                $('.step.active').removeClass('active');
            }
        }, 3000);

        // Fit bounds untuk menampilkan seluruh rute
        map.fitBounds(routeLine.getBounds());

        // Tambahkan kontrol zoom
        L.control.zoom({
            position: 'topright'
        }).addTo(map);

        // Tambahkan tombol lokasi
        L.control.locate({
            position: 'topright',
            strings: {
                title: "Tunjukkan lokasi saya"
            }
        }).addTo(map);
    }

</script>