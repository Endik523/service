{{--
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

</html> --}}





<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kurir | OTW Computer</title>
    <!-- Manifest PWA -->
    <link rel="manifest" href="/manifest.json">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e6e9ff;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --success-light: #e6f7fd;
            --warning: #f8961e;
            --warning-light: #fff4e8;
            --danger: #f72585;
            --danger-light: #ffebf3;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #f1f3f5;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .app-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .app-title i {
            font-size: 22px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
            box-shadow: var(--shadow-sm);
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 500;
            font-size: 15px;
        }

        .user-role {
            font-size: 12px;
            color: var(--gray);
            margin-top: 2px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-card.pending {
            border-left-color: var(--warning);
        }

        .stat-card.progress {
            border-left-color: var(--primary);
        }

        .stat-card.completed {
            border-left-color: var(--success);
        }

        .stat-content {
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

        .stat-icon.pending {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .stat-icon.progress {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon.completed {
            background-color: var(--success-light);
            color: var(--success);
        }

        .stat-text h3 {
            font-size: 14px;
            color: var(--gray);
            font-weight: 500;
        }

        .stat-text p {
            font-size: 24px;
            font-weight: 600;
            margin-top: 5px;
        }

        /* Orders Section */
        .orders-section {
            background: var(--white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: 20px;
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }

        .section-actions {
            display: flex;
            gap: 15px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 10px 15px 10px 38px;
            border: 1px solid #e0e0e0;
            border-radius: var(--radius-md);
            font-size: 14px;
            width: 220px;
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 14px;
        }

        .filter-btn {
            background: var(--white);
            border: 1px solid #e0e0e0;
            border-radius: var(--radius-md);
            padding: 10px 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Orders List */
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .order-card {
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--radius-md);
            padding: 18px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: rgba(67, 97, 238, 0.2);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .order-id {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary);
        }

        .order-status {
            padding: 5px 10px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-progress {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .status-completed {
            background-color: var(--success-light);
            color: var(--success);
        }

        .order-details {
            margin-bottom: 18px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }

        .detail-label {
            width: 100px;
            font-size: 13px;
            color: var(--gray);
            flex-shrink: 0;
        }

        .detail-value {
            flex: 1;
            font-size: 13px;
            font-weight: 500;
            word-break: break-word;
        }

        .order-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
            flex: 1;
            justify-content: center;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 3px 6px rgba(67, 97, 238, 0.2);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #3ab8df;
            box-shadow: 0 3px 6px rgba(76, 201, 240, 0.2);
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #e41a72;
            box-shadow: 0 3px 6px rgba(247, 37, 133, 0.2);
        }

        /* Loading State */
        .loading-state {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            grid-column: 1 / -1;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            grid-column: 1 / -1;
            background: var(--gray-light);
            border-radius: var(--radius-md);
        }

        .empty-icon {
            font-size: 50px;
            color: #d1d5db;
            margin-bottom: 15px;
        }

        .empty-text {
            color: var(--gray);
            font-size: 15px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: var(--white);
            margin: 5% auto;
            padding: 25px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: slideDown 0.3s;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }

        .close-modal {
            color: var(--gray);
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            background: none;
            border: none;
            padding: 5px;
        }

        .close-modal:hover {
            color: var(--danger);
        }

        /* Map Container */
        .map-container {
            height: 300px;
            width: 100%;
            border-radius: var(--radius-md);
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
        }

        #trackingMap {
            height: 100%;
            width: 100%;
        }

        /* Tracking Info */
        .tracking-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .live-tracking-badge {
            background-color: var(--danger);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .tracking-details {
            display: flex;
            gap: 15px;
        }

        .tracking-detail {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: var(--gray);
        }

        .tracking-detail i {
            color: var(--primary);
        }

        .tracking-value {
            font-weight: 500;
            color: var(--dark);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .section-actions {
                width: 100%;
            }

            .search-box {
                flex: 1;
            }

            .search-box input {
                width: 100%;
            }

            .orders-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                margin: 10% auto;
                width: 95%;
            }
        }
    </style>

    <style>
        .user-profile {
            position: relative;
            margin-left: 20px;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }

        /* Main toggle button */
        .user-avatar.dropdown-toggle {
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px 12px 6px 8px;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            outline: none;
        }

        .user-avatar.dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .user-avatar.dropdown-toggle::after {
            display: inline-block;
            margin-left: 8px;
            vertical-align: middle;
            content: "";
            border-top: 5px solid;
            border-right: 5px solid transparent;
            border-left: 5px solid transparent;
            color: rgba(255, 255, 255, 0.7);
            transition: transform 0.2s ease;
        }

        .user-avatar.dropdown-toggle.show::after {
            transform: rotate(-180deg);
        }

        /* Avatar container */
        .avatar-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Online status indicator */
        .status-indicator {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 12px;
            height: 12px;
            background-color: #4ade80;
            border-radius: 50%;
            border: 2px solid #1e293b;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Username text */
        .user-name {
            color: #05417d;
            font-weight: 500;
            font-size: 0.875rem;
            letter-spacing: 0.2px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Dropdown menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-radius: 12px;
            padding: 8px 0;
            min-width: 200px;
            background: #ffffff;
            margin-top: 12px;
            transform-origin: top right;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: #ffffff;
            transform: rotate(45deg);
            box-shadow: -3px -3px 5px rgba(0, 0, 0, 0.02);
            z-index: -1;
        }

        /* Menu items */
        .dropdown-item {
            padding: 10px 16px;
            color: #334155;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            position: relative;
            text-decoration: none;
        }

        .dropdown-item i {
            margin-right: 12px;
            color: #64748b;
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
            color: #1e40af;
            transform: translateX(2px);
        }

        .dropdown-item:hover i {
            color: #1e40af;
        }

        /* Divider */
        .dropdown-divider {
            margin: 6px 0;
            border-top: 1px solid #e2e8f0;
            opacity: 0.5;
        }

        /* Logout button */
        .logout-btn {
            color: #dc2626 !important;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #fee2e2 !important;
            color: #b91c1c !important;
        }

        .logout-btn i {
            color: #dc2626 !important;
        }

        /* Ripple effect */
        .ripple-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .dropdown-item:hover .ripple-effect {
            opacity: 1;
        }

        /* Animations */
        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(-5px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .dropdown-menu.show {
            animation: fadeInScale 0.2s ease-out forwards;
            display: block;
        }

        /* Focus states for accessibility */
        .user-avatar.dropdown-toggle:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .dropdown-item:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: -2px;
            background: #f1f5f9;
        }
    </style>

</head>

<body>
    <div class="container">
        <header class="app-header">
            <h1 class="app-title">
                <i class="fas fa-motorcycle"></i>
                Dashboard Kurir
            </h1>
            <div class="user-profile">
                <div class="dropdown">
                    <button class="user-avatar dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-wrapper">
                            {{-- <img src="#" alt="User Avatar" class="avatar-img"> --}}
                            <span class="status-indicator"></span>
                        </div>
                        <span class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</span>
                    </button>

                </div>
            </div>
        </header>

        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-content">
                    <div class="stat-icon pending">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-text">
                        <h3>Menunggu Penjemputan</h3>
                        <p id="assigned-count">0</p>
                    </div>
                </div>
            </div>
            <div class="stat-card progress">
                <div class="stat-content">
                    <div class="stat-icon progress">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-text">
                        <h3>Dalam Pengantaran</h3>
                        <p id="progress-count">0</p>
                    </div>
                </div>
            </div>
            <div class="stat-card completed">
                <div class="stat-content">
                    <div class="stat-icon completed">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-text">
                        <h3>Selesai</h3>
                        <p id="completed-count">0</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="orders-section">
            <div class="section-header">
                <h2 class="section-title">Daftar Pesanan</h2>
                <div class="section-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Cari pesanan..." id="search-input">
                    </div>
                    <button class="filter-btn" id="status-filter">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                </div>
            </div>

            <div class="orders-grid" id="orders-list">
                <div class="loading-state">
                    <div class="spinner"></div>
                </div>
            </div>
        </section>

        <!-- Tracking Modal -->
        <div id="trackingModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Pelacakan Pengantaran</h3>
                    <button class="close-modal">&times;</button>
                </div>

                <div class="map-container">
                    <div id="trackingMap"></div>
                </div>

                <div class="tracking-info">
                    <span class="live-tracking-badge">
                        <i class="fas fa-satellite-dish"></i> LIVE TRACKING
                    </span>

                    <div class="tracking-details">
                        <div class="tracking-detail">
                            <i class="fas fa-road"></i>
                            <span class="tracking-value" id="tracking-distance">-</span>
                        </div>
                        <div class="tracking-detail">
                            <i class="fas fa-clock"></i>
                            <span class="tracking-value" id="tracking-eta">-</span>
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <button class="btn btn-success" id="completeDelivery">
                        <i class="fas fa-check-circle"></i> Tandai Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Global variables
        let currentOrder = null;
        let map = null;
        let userMarker = null;
        let courierMarker = null;
        let watchId = null;
        let allOrders = [];

        // Function to render orders with new status flow
        function renderOrders(orders) {
            const ordersList = document.getElementById('orders-list');

            if (orders.length === 0) {
                ordersList.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-box-open empty-icon"></i>
                        <p class="empty-text">Tidak ada pesanan yang ditugaskan</p>
                    </div>
                `;
                return;
            }

            let html = '';

            // Update stats
            const stats = {
                assigned: 0,
                in_progress: 0,
                completed: 0
            };

            orders.forEach(order => {
                // Count statuses
                if (order.status === 'completed') stats.completed++;
                else if (order.status === 'in_progress') stats.in_progress++;
                else stats.assigned++;

                let statusClass, statusText;

                switch (order.status) {
                    case 'assigned':
                    case 'pending':
                        statusClass = 'status-pending';
                        statusText = 'MENUNGGU';
                        break;
                    case 'in_progress':
                        statusClass = 'status-progress';
                        statusText = 'DIANTAR';
                        break;
                    case 'completed':
                        statusClass = 'status-completed';
                        statusText = 'SELESAI';
                        break;
                    default:
                        statusClass = 'status-pending';
                        statusText = 'MENUNGGU';
                }

                // Format date
                const orderDate = new Date(order.tgl_pesan);
                const formattedDate = orderDate.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                html += `
                <div class="order-card" data-order-id="${order.id}">
                    <div class="order-header">
                        <span class="order-id">#${order.id_random}</span>
                        <span class="order-status ${statusClass}">${statusText}</span>
                    </div>
                    <div class="order-details">
                        <div class="detail-row">
                            <span class="detail-label">Pelanggan</span>
                            <span class="detail-value">${order.username}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Perangkat</span>
                            <span class="detail-value">${order.barang}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Kerusakan</span>
                            <span class="detail-value">${order.pesan || '-'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Alamat</span>
                            <span class="detail-value">${order.alamat}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal</span>
                            <span class="detail-value">${formattedDate}</span>
                        </div>
                    </div>
                    <div class="order-actions">
                        <button class="btn btn-outline view-map-btn" data-address="${order.alamat}">
                            <i class="fas fa-map-marked-alt"></i> Peta
                        </button>
                        ${order.status === 'pending' || order.status === 'assigned' ? `
                        <button class="btn btn-primary confirm-pickup-btn">
                            <i class="fas fa-check"></i> Jemput
                        </button>
                        ` : ''}
                        ${order.status === 'in_progress' ? `
                        <button class="btn btn-success track-delivery-btn">
                            <i class="fas fa-truck"></i> Lacak
                        </button>
                        ` : ''}
                    </div>
                </div>`;
            });

            // Update stats display
            document.getElementById('assigned-count').textContent = stats.assigned;
            document.getElementById('progress-count').textContent = stats.in_progress;
            document.getElementById('completed-count').textContent = stats.completed;

            ordersList.innerHTML = html;

            // Store orders for search functionality
            allOrders = orders;

            // Add event listeners
            addOrderEventListeners();
        }

        // Add event listeners to order buttons
        function addOrderEventListeners() {
            // Confirm pickup buttons
            document.querySelectorAll('.confirm-pickup-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const orderId = this.closest('.order-card').dataset.orderId;
                    confirmOrderPickup(orderId);
                });
            });

            // Track delivery buttons
            document.querySelectorAll('.track-delivery-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const orderId = this.closest('.order-card').dataset.orderId;
                    const order = allOrders.find(o => o.id == orderId);
                    startOrderTracking(order);
                });
            });

            // View map buttons
            document.querySelectorAll('.view-map-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const address = this.dataset.address;
                    window.open(`https://maps.google.com/?q=${encodeURIComponent(address)}`, '_blank');
                });
            });
        }

        // Confirm order pickup
        async function confirmOrderPickup(orderId) {
            try {
                const response = await fetch(`/api/kurir/orders/${orderId}/pickup`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: 'in_progress'
                    })
                });

                if (!response.ok) {
                    throw new Error('Gagal mengkonfirmasi penjemputan');
                }

                const result = await response.json();
                showNotification('success', 'Penjemputan dikonfirmasi!');
                loadOrders();
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Gagal mengkonfirmasi penjemputan');
            }
        }

        // Start order tracking
        function startOrderTracking(order) {
            currentOrder = order;
            document.getElementById('trackingModal').style.display = 'block';

            // Initialize map
            initTrackingMap(order);

            // Start geolocation tracking
            if (navigator.geolocation) {
                watchId = navigator.geolocation.watchPosition(
                    position => updateCourierPosition(position),
                    error => console.error('Geolocation error:', error),
                    { enableHighAccuracy: true, maximumAge: 10000 }
                );
            }

            // Send initial location to server
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    updateLocationOnServer(position.coords.latitude, position.coords.longitude);
                });
            }
        }

        // Initialize tracking map
        function initTrackingMap(order) {
            if (!map) {
                map = L.map('trackingMap').setView([-7.2575, 112.7521], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
            }

            // Clear existing markers
            if (userMarker) map.removeLayer(userMarker);
            if (courierMarker) map.removeLayer(courierMarker);

            // Add user location marker (static for now)
            userMarker = L.marker([-7.2575, 112.7521], {
                icon: L.divIcon({
                    html: '<div style="background-color: white; border-radius: 50%; padding: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"><i class="fas fa-map-marker-alt fa-2x" style="color: #4361ee;"></i></div>',
                    iconSize: [40, 40],
                    className: 'user-marker'
                })
            }).addTo(map).bindPopup("<b>Lokasi Pelanggan</b><br>" + order.alamat);

            // Add courier marker (will be updated)
            courierMarker = L.marker([-7.2575, 112.7521], {
                icon: L.divIcon({
                    html: '<div style="background-color: white; border-radius: 50%; padding: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"><i class="fas fa-motorcycle fa-2x" style="color: #f72585;"></i></div>',
                    iconSize: [40, 40],
                    className: 'courier-marker'
                })
            }).addTo(map).bindPopup("<b>Lokasi Anda</b>");

            // Fit bounds to show both markers
            const group = new L.featureGroup([userMarker, courierMarker]);
            map.fitBounds(group.getBounds());
        }

        // Update courier position on map
        function updateCourierPosition(position) {
            const { latitude, longitude } = position.coords;

            // Update marker position
            if (courierMarker) {
                courierMarker.setLatLng([latitude, longitude]);
                courierMarker.bindPopup("<b>Lokasi Anda</b><br>" + latitude.toFixed(5) + ", " + longitude.toFixed(5)).openPopup();
            }

            // Update server with new location
            updateLocationOnServer(latitude, longitude);

            // Calculate distance and ETA (simplified)
            calculateDistanceAndETA(latitude, longitude);

            // Center map on new position
            if (map) {
                map.setView([latitude, longitude]);
            }
        }

        // Update location on server
        async function updateLocationOnServer(lat, lng) {
            try {
                await fetch('/api/kurir/location', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        latitude: lat,
                        longitude: lng,
                        order_id: currentOrder.id
                    })
                });
            } catch (error) {
                console.error('Error updating location:', error);
            }
        }

        // Calculate distance and ETA (simplified)
        function calculateDistanceAndETA(lat, lng) {
            // In a real app, you would use a proper distance calculation
            // This is just for demonstration
            const distance = (Math.random() * 5 + 1).toFixed(1);
            const eta = (distance * 3).toFixed(0);

            document.getElementById('tracking-distance').textContent = `${distance} km`;
            document.getElementById('tracking-eta').textContent = `${eta} menit`;
        }

        // Complete delivery
        document.getElementById('completeDelivery').addEventListener('click', async function () {
            if (!currentOrder) return;

            try {
                const response = await fetch(`/api/kurir/orders/${currentOrder.id}/complete`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: 'completed'
                    })
                });

                if (!response.ok) {
                    throw new Error('Gagal mengupdate status');
                }

                // Stop geolocation tracking
                if (watchId && navigator.geolocation) {
                    navigator.geolocation.clearWatch(watchId);
                }

                // Close modal
                document.getElementById('trackingModal').style.display = 'none';

                // Reload orders
                loadOrders();

                showNotification('success', 'Pengantaran berhasil diselesaikan!');
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Gagal menyelesaikan pengantaran');
            }
        });

        // Close modal
        document.querySelector('.close-modal').addEventListener('click', function () {
            document.getElementById('trackingModal').style.display = 'none';

            // Stop geolocation tracking
            if (watchId && navigator.geolocation) {
                navigator.geolocation.clearWatch(watchId);
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function (event) {
            if (event.target === document.getElementById('trackingModal')) {
                document.getElementById('trackingModal').style.display = 'none';

                // Stop geolocation tracking
                if (watchId && navigator.geolocation) {
                    navigator.geolocation.clearWatch(watchId);
                }
            }
        });

        // Show notification
        function showNotification(type, message) {
            // In a real app, you would use a proper notification system
            alert(message);
        }

        // Search functionality
        document.getElementById('search-input').addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            if (searchTerm === '') {
                renderOrders(allOrders);
                return;
            }

            const filteredOrders = allOrders.filter(order =>
                order.id_random.toLowerCase().includes(searchTerm) ||
                order.username.toLowerCase().includes(searchTerm) ||
                order.barang.toLowerCase().includes(searchTerm) ||
                (order.masalah_kerusakan && order.masalah_kerusakan.toLowerCase().includes(searchTerm))
            );

            renderOrders(filteredOrders);
        });

        // Filter by status
        document.getElementById('status-filter').addEventListener('click', function () {
            // In a real app, you would implement a proper filter dropdown
            alert('Fitur filter akan diimplementasikan');
        });

        // Load orders from API
        async function loadOrders() {
            // Show loading
            document.getElementById('orders-list').innerHTML = `
                <div class="loading-state">
                    <div class="spinner"></div>
                </div>
            `;

            try {
                const response = await fetch('/api/kurir/orders');

                if (!response.ok) {
                    throw new Error('Gagal memuat pesanan');
                }

                const orders = await response.json();
                renderOrders(orders);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('orders-list').innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-exclamation-circle empty-icon"></i>
                        <p class="empty-text">Gagal memuat pesanan. Silakan coba lagi.</p>
                    </div>
                `;
            }
        }

        // Initialize the app
        document.addEventListener('DOMContentLoaded', () => {
            loadOrders();

            // Check if PWA is installed
            if (window.matchMedia('(display-mode: standalone)').matches) {
                console.log('Running as PWA');
            }

            // Register service worker for PWA
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            }
        });
    </script>
</body>

</html>