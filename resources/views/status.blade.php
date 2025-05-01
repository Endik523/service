@extends('layouts.auth')

@section('body')
    <style>
        .map-container {
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #courierMap {
            height: 100%;
            width: 100%;
        }

        .tracking-info {
            display: flex;
            justify-content: space-between;
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .tracking-item {
            text-align: center;
        }

        .tracking-item i {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .eta-display {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin: 20px 0;
        }

        .eta-label {
            font-size: 14px;
            color: #6c757d;
        }

        .status-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
        }

        .status-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .status-header h2 {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .status-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #3490dc;
        }

        .status-card h3 {
            color: #3490dc;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .info-table td {
            padding: 12px 15px;
            vertical-align: top;
        }

        .info-table tr td:first-child {
            font-weight: 600;
            color: #495057;
            width: 30%;
        }

        .courier-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-action {
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0 10px;
        }

        .btn-cancel {
            background-color: #fff;
            border: 2px solid #e74c3c;
            color: #e74c3c;
        }

        .btn-cancel:hover {
            background-color: #e74c3c;
            color: white;
        }

        .btn-pay {
            background-color: #3490dc;
            color: white;
            border: 2px solid #3490dc;
        }

        .btn-pay:hover {
            background-color: #2874a6;
            border-color: #2874a6;
        }

        .alert-box {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
            font-weight: 500;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .badge-processing {
            background-color: #d4edff;
            color: #004085;
        }

        .badge-canceled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .action-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }

        .price-highlight {
            font-size: 18px;
            font-weight: 700;
            color: #28a745;
        }

        .damage-description {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid #e74c3c;
            margin-bottom: 15px;
        }

        .loading-spinner {
            display: none;
            margin-left: 10px;
        }

        .status-timeline {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .steps {
            position: relative;
            padding-left: 30px;
            margin-top: 15px;
        }

        .step {
            position: relative;
            padding-bottom: 25px;
            padding-left: 30px;
        }

        .step:last-child {
            padding-bottom: 0;
        }

        .step::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #ddd;
            border: 3px solid white;
            z-index: 2;
        }

        .step.completed::before {
            background: #28a745;
        }

        .step.active::before {
            background: #3490dc;
            animation: pulse 1.5s infinite;
        }

        .step::after {
            content: '';
            position: absolute;
            left: 7px;
            top: 20px;
            width: 2px;
            height: 100%;
            background: #ddd;
        }

        .step:last-child::after {
            display: none;
        }

        .step i {
            position: absolute;
            left: -25px;
            top: 2px;
            color: white;
            z-index: 3;
            font-size: 12px;
        }

        .step span {
            font-weight: 600;
            display: block;
        }

        .step small {
            color: #6c757d;
            font-size: 12px;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(52, 144, 220, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(52, 144, 220, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(52, 144, 220, 0);
            }
        }
    </style>

    <div class="status-container">
        @if (!$order || ($damageDetails->isEmpty() && !$kurir))
            <div class="text-center py-5">
                <div class="alert alert-warning py-4">
                    <h4 class="mb-0">STATUS BELUM TERSEDIA</h4>
                </div>
            </div>
        @else
            <div class="status-header">
                <h2>Status Pesanan Anda</h2>
                <div class="status-badge badge-processing">
                    <i class="fas fa-sync-alt mr-2"></i>Dalam Proses
                </div>
                <p class="text-muted">ID Pesanan: <strong>{{ $order->id_random ?? $detail->id_order ?? 'N/A' }}</strong></p>
            </div>

            <!-- Kurir Information Section -->
            @if ($kurir)
                {{-- <div class="status-card" id="kurir-info">
                    <h3><i class="fas fa-motorcycle mr-2"></i>Informasi Kurir</h3>
                    <table class="info-table">
                        <tr>
                            <td>Nama Kurir</td>
                            <td>{{ $kurir->name }}</td>
                        </tr>
                        <tr>
                            <td>Foto Kurir</td>
                            <td>
                                <img src="{{ $kurir->photo ?? asset('images/default-courier.jpg') }}" alt="Foto Kurir"
                                    class="courier-img" onerror="this.src='{{ asset('images/default-courier.jpg') }}'">
                            </td>
                        </tr>
                        <tr>
                            <td>Kendaraan</td>
                            <td>{{ $kurir->merk_motor }} ({{ $kurir->plat_motor }})</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="text-success"><i class="fas fa-check-circle mr-2"></i>Dalam perjalanan</span>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div> --}}

                <div class="status-card" id="kurir-info">
                    <h3><i class="fas fa-motorcycle mr-2"></i>Informasi Kurir</h3>
                    <table class="info-table">
                        <tr>
                            <td>Nama Kurir</td>
                            <td>{{ $kurir->name }}</td>
                        </tr>
                        <tr>
                            <td>Foto Kurir</td>
                            <td>
                                <img src="{{ $kurir->photo ?? asset('images/default-courier.jpg') }}" alt="Foto Kurir"
                                    class="courier-img" onerror="this.src='{{ asset('images/default-courier.jpg') }}'">
                            </td>
                        </tr>
                        <tr>
                            <td>Kendaraan</td>
                            <td>{{ $kurir->merk_motor }} ({{ $kurir->plat_motor }})</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span class="text-success"><i class="fas fa-check-circle mr-2"></i>Dalam perjalanan</span>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="status-timeline mt-4">
                    <h4><i class="fas fa-clipboard-list mr-2"></i>Status Pengantaran</h4>
                    <div class="steps">
                        <div class="step completed">
                            <i class="fas fa-check-circle"></i>
                            <span>Pesanan Diterima</span>
                            <small>10:00 WIB</small>
                        </div>
                        <div class="step completed">
                            <i class="fas fa-check-circle"></i>
                            <span>Kurir Menuju Lokasi</span>
                            <small>10:15 WIB</small>
                        </div>
                        <div class="step active">
                            <i class="fas fa-motorcycle"></i>
                            <span>Dalam Perjalanan</span>
                            <small>Estimasi 15-20 menit</small>
                        </div>
                        <div class="step">
                            <i class="far fa-clock"></i>
                            <span>Sampai di Tujuan</span>
                            <small>-</small>
                        </div>
                    </div>
                </div>

                <div class="action-buttons mt-3">
                    <button id="alternateRoute" class="btn btn-outline-primary btn-sm mr-2">
                        <i class="fas fa-route mr-1"></i>Rute Alternatif
                    </button>
                    <button class="btn btn-outline-success btn-sm mr-2">
                        <i class="fas fa-phone mr-1"></i>Hubungi Kurir
                    </button>
                    <button class="btn btn-outline-info btn-sm">
                        <i class="fas fa-share-alt mr-1"></i>Bagikan Lokasi
                    </button>
                </div>

            @else
                <div class="alert alert-warning alert-box">
                    <i class="fas fa-info-circle mr-2"></i>Pesanan ini tidak menggunakan layanan kurir
                </div>
            @endif

            <!-- Damage Information Section -->
            @if ($order)
                <div class="status-card" id="masalah-kerusakan">
                    <h3><i class="fas fa-tools mr-2"></i>Detail Kerusakan</h3>
                    <div class="damage-description">
                        <p class="mb-0">{{ $order->masalah_kerusakan ?? 'Deskripsi kerusakan tidak tersedia.' }}</p>
                    </div>
                    @if($order->damage_photos)
                        <div class="mt-4">
                            <h5 class="mb-3">Foto Kerusakan:</h5>
                            <div class="row">
                                @foreach(json_decode($order->damage_photos) as $photo)
                                    <div class="col-md-4 mb-3">
                                        <img src="{{ asset('storage/' . $photo) }}" alt="Foto Kerusakan" class="img-thumbnail"
                                            style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                                            onclick="openModal('{{ asset('storage/' . $photo) }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Cost Information Section -->
            @if ($damageDetails->isNotEmpty())
                <div class="status-card" id="total-biaya">
                    <h3><i class="fas fa-receipt mr-2"></i>Rincian Biaya</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
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
                                <tr class="table-active">
                                    <td colspan="2" class="text-right font-weight-bold">Total Biaya:</td>
                                    <td class="price-highlight">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-warning alert-box">
                    <i class="fas fa-info-circle mr-2"></i>Total biaya belum dihitung
                </div>
            @endif

            <!-- Action Buttons Section -->
            @if($totalBiaya > 0)
                <div class="action-section">
                    <div id="pdf-button" class="mb-4">
                        <p class="text-muted mb-2">Silahkan download invoice untuk pembayaran offline</p>
                        <a href="{{ route('download.pdf', $order->id) }}" class="btn btn-outline-success btn-action">
                            <i class="fas fa-file-pdf mr-2"></i>Download Invoice
                        </a>
                    </div>

                    <div class="d-flex justify-content-center flex-wrap">
                        <button type="button" class="btn btn-cancel btn-action" onclick="confirmCancel()">
                            <i class="fas fa-times mr-2"></i>Batalkan Pesanan
                        </button>
                        <button type="button" class="btn btn-pay btn-action" onclick="continuePayment()">
                            <i class="fas fa-credit-card mr-2"></i>Bayar Sekarang
                            <span class="loading-spinner spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Status Message Area -->
            <div id="orderStatus" class="mt-4"></div>
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
                $('.status-badge')
                    .removeClass('badge-processing')
                    .addClass('badge-canceled')
                    .html('<i class="fas fa-times-circle mr-2"></i>Dibatalkan');

                // You would typically make an AJAX call to update the order status here
                // axios.post('/orders/cancel', { order_id: '{{ $order->id ?? "" }}' })
                //     .then(response => { ... })
                //     .catch(error => { ... });
            }, 1500);
        }

        // Function to continue to payment
        function continuePayment() {
            $('.loading-spinner').show();
            $('.btn-pay').prop('disabled', true);

            // Simulate processing
            setTimeout(() => {
                // In a real scenario, you would redirect to payment gateway
                window.location.href = "https://mitrans.com/payment";


            }, 1000);
        }

        // Initialize tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        // Inisialisasi peta dengan fokus Surabaya
        function initMap() {
            // Koordinat tengah Surabaya
            const surabayaCenter = [-7.2575, 112.7521];

            // Buat peta dengan batas wilayah Surabaya
            const map = L.map('courierMap').setView(surabayaCenter, 13);

            // Batasi viewport ke Surabaya
            map.setMaxBounds([
                [-7.10, 112.45], // Barat Laut
                [-7.35, 112.90]   // Tenggara
            ]);

            // Tambahkan tile layer (Ganti dengan API key Anda)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker untuk lokasi user
            const userMarker = L.marker([-7.2650, 112.7560], {
                icon: L.divIcon({
                    html: '<i class="fas fa-map-marker-alt fa-2x" style="color: #3490dc;"></i>',
                    iconSize: [30, 30],
                    className: 'my-html-icon'
                })
            }).addTo(map).bindPopup("Lokasi Anda");

            // Simulasikan pergerakan kurir (di production, ini data real dari GPS)
            const courierPath = [
                [-7.2750, 112.7460],
                [-7.2700, 112.7480],
                [-7.2675, 112.7520],
                [-7.2650, 112.7560] // Tujuan akhir
            ];

            const courierMarker = L.marker(courierPath[0], {
                icon: L.divIcon({
                    html: '<i class="fas fa-motorcycle fa-2x" style="color: #e74c3c;"></i>',
                    iconSize: [30, 30],
                    className: 'my-html-icon'
                })
            }).addTo(map).bindPopup("Kurir Anda");

            // Gambar rute
            const routeLine = L.polyline(courierPath, { color: '#e74c3c' }).addTo(map);

            // Animasi pergerakan kurir
            let currentPoint = 0;
            const moveInterval = setInterval(() => {
                if (currentPoint < courierPath.length - 1) {
                    currentPoint++;
                    courierMarker.setLatLng(courierPath[currentPoint]);

                    // Update ETA berdasarkan titik yang tersisa
                    const remainingPoints = courierPath.length - currentPoint - 1;
                    const etaMinutes = remainingPoints * 3;
                    document.getElementById('etaTime').textContent = etaMinutes + " menit";

                    // Update jarak tersisa
                    const remainingDistance = (remainingPoints * 0.8).toFixed(1);
                    document.getElementById('distanceText').textContent = remainingDistance + " km";

                    // Jika sudah dekat, ubah status
                    if (remainingPoints < 2) {
                        document.getElementById('routeType').textContent = "Hampir Sampai";
                    }
                } else {
                    clearInterval(moveInterval);
                    document.getElementById('etaTime').textContent = "Sudah Sampai";
                    document.getElementById('distanceText').textContent = "0 km";
                    document.getElementById('durationText').textContent = "Tiba";
                    document.getElementById('routeType').textContent = "Perjalanan Selesai";
                }
            }, 3000);

            // Fit bounds untuk menampilkan seluruh rute
            map.fitBounds(routeLine.getBounds());
        }

        // Panggil fungsi initMap ketika dokumen siap
        $(document).ready(function () {
            initMap();

            // Tambahkan event listener untuk tombol rute alternatif
            $('#alternateRoute').click(function () {
                alert("Menghitung rute alternatif...");
                // Di sini Anda bisa menambahkan logika untuk menghitung rute alternatif
            });
        });
    </script>

    @if($order && $order->damage_photos)
        <!-- Include Bootstrap JS for modal functionality -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    @endif

@endsection
