<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penjualan | Smart Seller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background: #f3f4f6;
            color: #333;
        }

        /* SIDEBAR GRADASI */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e3a8a 0%, #7c3aed 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar h2 {
            font-weight: 700;
            font-size: 1.6rem;
            color: #fff;
            margin-bottom: 50px;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .menu {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .menu a {
            text-decoration: none;
            color: white;
            padding: 14px 30px;
            margin: 8px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        /* KONTEN UTAMA PUTIH */
        .content {
            flex: 1;
            padding: 50px;
            background: #ffffff;
            overflow-y: auto;
        }

        .content h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
        }

        .content p {
            color: #4b5563;
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        canvas {
            max-width: 600px;
            background: #f9fafb;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* Tombol Logout */
        .logout-btn {
            margin-top: auto;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            padding: 12px 50px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
                padding: 30px 0;
            }

            .content {
                padding: 30px;
            }

            .sidebar h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Smart Seller</h2>
        <div class="menu">
            <a href="#" class="active">Dashboard</a>
            <a href="{{ route('aktivitas') }}">Aktivitas Seller</a>
            <a href="{{ route('dbpenjualan') }}">Database Penjualan</a>
        </div>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="logout-btn">
           Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <div class="content">
        <h1>Grafik Penjualan</h1>
        <p>Total penjualan produk Black Garlic dan Muli Water saat ini.</p>

        <!-- Chart -->
        <canvas id="myChart"></canvas>
    </div>

<script>
    const labels = {!! json_encode(array_keys($salesData)) !!};
    const data = {!! json_encode(array_values($salesData)) !!};

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Produk Terjual',
                data: data,
                backgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Total Pembelian per Kategori'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


</body>
</html>
