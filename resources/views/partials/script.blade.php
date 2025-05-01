<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



{{--
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

    // Map initialization function
    function initMap() {
        // Surabaya coordinates
        const surabayaCenter = [-7.2575, 112.7521];

        // Create map with Surabaya bounds
        const map = L.map('courierMap').setView(surabayaCenter, 13);

        // Set Surabaya boundaries
        map.setMaxBounds([
            [-7.10, 112.45], // NW
            [-7.35, 112.90]   // SE
        ]);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Add user marker
        const userMarker = L.marker([-7.2650, 112.7560], {
            icon: L.divIcon({
                html: '<i class="fas fa-map-marker-alt fa-2x" style="color: #3490dc;"></i>',
                iconSize: [30, 30],
                className: 'my-html-icon'
            })
        }).addTo(map).bindPopup("Lokasi Anda");

        // Courier path simulation (Surabaya locations)
        const courierPath = [
            [-7.2750, 112.7460], // Barat
            [-7.2700, 112.7480],
            [-7.2675, 112.7520],
            [-7.2650, 112.7560]  // Pusat
        ];

        // Add courier marker
        const courierMarker = L.marker(courierPath[0], {
            icon: L.divIcon({
                html: '<i class="fas fa-motorcycle fa-2x" style="color: #e74c3c;"></i>',
                iconSize: [30, 30],
                className: 'my-html-icon'
            })
        }).addTo(map).bindPopup("Kurir Anda");

        // Draw route
        const routeLine = L.polyline(courierPath, { color: '#e74c3c' }).addTo(map);

        // Animate courier movement
        let currentPoint = 0;
        const moveInterval = setInterval(() => {
            if (currentPoint < courierPath.length - 1) {
                currentPoint++;
                courierMarker.setLatLng(courierPath[currentPoint]);

                // Update ETA
                const remainingPoints = courierPath.length - currentPoint - 1;
                const etaMinutes = remainingPoints * 3;
                $('#etaTime').text(etaMinutes + " menit");

                // Update distance
                const remainingDistance = (remainingPoints * 0.8).toFixed(1);
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

        // Fit bounds to show entire route
        map.fitBounds(routeLine.getBounds());
    }
</script> --}}
