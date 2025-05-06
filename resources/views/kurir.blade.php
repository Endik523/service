<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Dashboard | OTW Computer</title>
    <!-- Manifest PWA -->
    <link rel="manifest" href="/manifest.json">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --white-color: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white-color);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .stat-icon.warning {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .stat-icon.success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .stat-info h3 {
            font-size: 14px;
            color: var(--gray-color);
            font-weight: 500;
        }

        .stat-info p {
            font-size: 24px;
            font-weight: 600;
            margin-top: 5px;
        }

        .orders-container {
            background: var(--white-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            margin-bottom: 30px;
        }

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .orders-header h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .search-filter {
            display: flex;
            gap: 15px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 8px 15px 8px 35px;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 14px;
            width: 200px;
        }

        .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
        }

        .filter-btn {
            background: var(--white-color);
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            padding: 8px 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .order-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .order-card {
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            padding: 15px;
            transition: all 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-id {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .order-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .status-in-progress {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .status-completed {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .order-details {
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }

        .detail-label {
            width: 100px;
            font-size: 13px;
            color: var(--gray-color);
        }

        .detail-value {
            flex: 1;
            font-size: 13px;
            font-weight: 500;
        }

        .order-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: var(--border-radius);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #3aa8d4;
        }

        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .empty-state {
            text-align: center;
            padding: 40px 0;
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 50px;
            color: #e0e0e0;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: var(--gray-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .orders-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-filter {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="header-left">
                <h1>Courier Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="profile">
                    <div class="profile-img">ME</div>
                    <div>
                        <p style="font-weight: 500;">Muhamad Effendy</p>
                        <p style="font-size: 12px; color: var(--gray-color);">Kurir</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-info">
                    <h3>Assigned Orders</h3>
                    <p id="assigned-count">0</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>In Progress</h3>
                    <p id="progress-count">0</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Completed</h3>
                    <p id="completed-count">0</p>
                </div>
            </div>
        </div>

        <div class="orders-container">
            <div class="orders-header">
                <h2>Assigned Orders</h2>
                <div class="search-filter">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search orders..." id="search-input">
                    </div>
                    <button class="filter-btn">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                </div>
            </div>

            <div class="order-list" id="orders-list">
                <div class="loading">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to render orders
        function renderOrders(orders) {
            const ordersList = document.getElementById('orders-list');

            if (orders.length === 0) {
                ordersList.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p>No orders assigned to you yet</p>
                    </div>
                `;
                return;
            }

            let html = '';

            // Update stats counters
            const assignedCount = orders.filter(o => o.status === 'pending' || o.status === 'assigned').length;
            const progressCount = orders.filter(o => o.status === 'in_progress' || o.status === 'processing').length;
            const completedCount = orders.filter(o => o.status === 'completed').length;

            document.getElementById('assigned-count').textContent = assignedCount;
            document.getElementById('progress-count').textContent = progressCount;
            document.getElementById('completed-count').textContent = completedCount;

            orders.forEach(order => {
                let statusClass, statusText;

                switch (order.status) {
                    case 'assigned':
                    case 'pending':
                        statusClass = 'status-pending';
                        statusText = 'Pending Pickup';
                        break;
                    case 'in_progress':
                    case 'processing':
                        statusClass = 'status-in-progress';
                        statusText = 'In Progress';
                        break;
                    case 'completed':
                        statusClass = 'status-completed';
                        statusText = 'Completed';
                        break;
                    default:
                        statusClass = 'status-pending';
                        statusText = 'Pending';
                }

                // Format date
                const orderDate = new Date(order.tgl_pesan);
                const formattedDate = orderDate.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                html += `
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">${order.id_random}</span>
                        <span class="order-status ${statusClass}">${statusText}</span>
                    </div>
                    <div class="order-details">
                        <div class="detail-row">
                            <span class="detail-label">Customer</span>
                            <span class="detail-value">${order.username}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Device</span>
                            <span class="detail-value">${order.barang}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Issue</span>
                            <span class="detail-value">${order.masalah_kerusakan || 'Not specified'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Address</span>
                            <span class="detail-value">${order.alamat}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Order Date</span>
                            <span class="detail-value">${formattedDate}</span>
                        </div>
                        ${order.jemput_barang ? `
                        <div class="detail-row">
                            <span class="detail-label">Pickup Time</span>
                            <span class="detail-value">${order.jemput_barang}</span>
                        </div>
                        ` : ''}
                    </div>
                    <div class="order-actions">
                        <a href="https://maps.google.com/?q=${encodeURIComponent(order.alamat)}" target="_blank" class="btn btn-outline">
                            <i class="fas fa-map-marker-alt"></i> View Map
                        </a>
                        ${order.status === 'pending' || order.status === 'assigned' ? `
                        <button onclick="updateOrderStatus(${order.id}, 'in_progress')" class="btn btn-primary">
                            <i class="fas fa-check"></i> Confirm Pickup
                        </button>
                        ` : ''}
                        ${order.status === 'in_progress' || order.status === 'processing' ? `
                        <button onclick="updateOrderStatus(${order.id}, 'completed')" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Mark Complete
                        </button>
                        ` : ''}
                    </div>
                </div>`;
            });

            ordersList.innerHTML = html;
        }

        // Function to update order status
        async function updateOrderStatus(orderId, newStatus) {
            try {
                const response = await fetch(`/api/orders/${orderId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to update order status');
                }

                const result = await response.json();
                alert(result.message || 'Order status updated successfully!');
                loadOrders();
            } catch (error) {
                console.error('Error updating order status:', error);
                alert('Error updating order status: ' + error.message);
            }
        }

        // Function to load orders from API
        async function loadOrders() {
            // Show loading state
            document.getElementById('orders-list').innerHTML = `
                <div class="loading">
                    <div class="spinner"></div>
                </div>
            `;

            try {
                // Fetch orders from your API
                const response = await fetch('/api/kurir/orders');

                if (!response.ok) {
                    throw new Error('Failed to fetch orders');
                }

                const orders = await response.json();
                renderOrders(orders);
            } catch (error) {
                console.error('Error loading orders:', error);
                document.getElementById('orders-list').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error loading orders. Please try again later.</p>
                    </div>
                `;
            }
        }

        // Search functionality
        document.getElementById('search-input').addEventListener('input', async (e) => {
            const searchTerm = e.target.value.toLowerCase();

            try {
                const response = await fetch(`/api/kurir/orders?search=${encodeURIComponent(searchTerm)}`);

                if (!response.ok) {
                    throw new Error('Failed to search orders');
                }

                const filteredOrders = await response.json();
                renderOrders(filteredOrders);
            } catch (error) {
                console.error('Error searching orders:', error);
            }
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            loadOrders();
        });
    </script>
</body>

</html>