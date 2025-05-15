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

    <div class="map-container">
        <div id="courierMap" style="height: 400px;"></div>
    </div>

    @if($kurir && $order->jemput_barang == 'yes')
        <div class="map-container">
            <div id="courierMap" style="height: 400px;"></div>
        </div>

        <script>
            // Koordinat awal peta (default jika data tidak ditemukan)
            const lokasi = [{{ $kurir->latitude ?? -1.258 }}, {{ $kurir->longitude ?? 10.753 }}]; // Lokasi default jika tidak ada data

            // Membuat peta menggunakan Leaflet
            const map = L.map('courierMap').setView(lokasi, 14);

            // Menambahkan tile OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Menambahkan marker untuk lokasi awal
            const marker = L.marker(lokasi).addTo(map);
            marker.bindPopup("<b>Lokasi Kurir</b>").openPopup();

            // Fungsi untuk mendapatkan lokasi kurir dari server
            function updateCourierLocation(courierId) {
                $.ajax({
                    url: `/api/kurir/location/${courierId}`, // API untuk mendapatkan lokasi kurir
                    method: 'GET',
                    success: function (data) {
                        if (data.latitude && data.longitude) {
                            const location = [data.latitude, data.longitude];
                            marker.setLatLng(location); // Update posisi marker

                            // Update peta untuk mengikuti posisi kurir
                            map.setView(location, 14);

                            // Update estimasi waktu tiba (ETA) dan jarak jika data tersedia
                            const distance = calculateDistance(location, [{{ $order->latitude ?? -7.2575 }}, {{ $order->longitude ?? 112.7521 }}]); // Lokasi tujuan
                            $('#distanceText').text(distance.toFixed(1) + " km");
                            $('#etaTime').text((distance / 0.5).toFixed(0) + " menit"); // Estimasi ETA berdasarkan kecepatan 30 km/jam
                        }
                    },
                    error: function (error) {
                        console.error('Gagal mendapatkan lokasi kurir', error);
                    }
                });
            }

            // Fungsi untuk menghitung jarak antara dua titik (menggunakan rumus Haversine)
            function calculateDistance([lat1, lon1], [lat2, lon2]) {
                const R = 6371; // Radius bumi dalam km
                const dLat = toRad(lat2 - lat1);
                const dLon = toRad(lon2 - lon1);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                const distance = R * c; // Jarak dalam km
                return distance;
            }

            // Fungsi untuk mengubah derajat ke radian
            function toRad(deg) {
                return deg * (Math.PI / 180);
            }

            // Perbarui lokasi kurir setiap 10 detik
            const courierId = {{ $kurir->id }}; // ID kurir
            setInterval(function () {
                updateCourierLocation(courierId);
            }, 10000); // Update setiap 10 detik
        </script>

    @else
        <div class="right-column" style="width: 100%;">
            {{-- Detail Kerusakan --}}
            {{-- Rincian Biaya --}}
        </div>
    @endif

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

    {{--
    <script>
        // Koordinat awal peta (default jika data tidak ditemukan)
        // const lokasi = [-1.258, 10.753];
        const lokasi = [{{ $kurir-> latitude ?? -1.258 }}, { { $kurir -> longitude ?? 10.753 } }]; // Lokasi default jika tidak ada data

        // Membuat peta menggunakan Leaflet
        const map = L.map('courierMap').setView(lokasi, 14);

        // Menambahkan tile OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menambahkan marker untuk lokasi awal
        const marker = L.marker(lokasi).addTo(map);
        marker.bindPopup("<b>Lokasi Kurir</b>").openPopup();

        // Fungsi untuk mendapatkan lokasi kurir dari server
        function updateCourierLocation(courierId) {
            $.ajax({
                url: `/api/kurir/location/${courierId}`, // API untuk mendapatkan lokasi kurir
                method: 'GET',
                success: function (data) {
                    if (data.latitude && data.longitude) {
                        const location = [data.latitude, data.longitude];
                        marker.setLatLng(location); // Update posisi marker

                        // Update peta untuk mengikuti posisi kurir
                        map.setView(location, 14);

                        // Update estimasi waktu tiba (ETA) dan jarak jika data tersedia
                        const distance = calculateDistance(location, [{{ $order-> latitude ?? -7.2575 }
                }, {{ $order-> longitude ?? 112.7521 }}]); // Lokasi tujuan
        $('#distanceText').text(distance.toFixed(1) + " km");
        $('#etaTime').text((distance / 0.5).toFixed(0) + " menit"); // Estimasi ETA berdasarkan kecepatan 30 km/jam
                                                                                                                                }
                                                                                                                            },
        error: function (error) {
            console.error('Gagal mendapatkan lokasi kurir', error);
        }
                                                                                                                        });
                                                                                                                    }

        // Fungsi untuk menghitung jarak antara dua titik (menggunakan rumus Haversine)
        function calculateDistance([lat1, lon1], [lat2, lon2]) {
            const R = 6371; // Radius bumi dalam km
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c; // Jarak dalam km
            return distance;
        }

        // Fungsi untuk mengubah derajat ke radian
        function toRad(deg) {
            return deg * (Math.PI / 180);
        }

        // Perbarui lokasi kurir setiap 10 detik
        const courierId = {{ $kurir-> id }}; // ID kurir
        setInterval(function () {
            updateCourierLocation(courierId);
        }, 10000); // Update setiap 10 detik
    </script> --}}

@endsection