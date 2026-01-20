<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Smart Seller</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e3a8a, #7c3aed);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar h2 {
            margin-bottom: 40px;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
        }

        .menu {
            width: 100%;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px 30px;
            margin: 6px 20px;
            border-radius: 12px;
            transition: 0.3s;
        }

        .menu a.active,
        .menu a:hover {
            background: rgba(255,255,255,0.25);
        }

        .logout-btn {
            margin-top: auto;
            margin-bottom: 20px;
            background: #ef4444;
            padding: 12px 50px;
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: #f9fafb;
            margin-left: 260px;
        }

        h1 {
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
        }

        /* KPI */
        .kpi {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .kpi-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .kpi-card span {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .kpi-card h2 {
            margin-top: 10px;
            font-size: 1.5rem;
            color: #111827;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 10px;
        }

        .chart-box {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            margin-bottom: 10px;
        }

        .chart-box h3 {
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: #111827;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>

<!-- SIDEBAR -->
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

<!-- CONTENT -->
<div class="content">
    <h1>Dashboard</h1>

    <!-- KPI -->
    <div class="kpi">
        <div class="kpi-card">
            <span>Total Penjualan</span>
            <h2>{{ $totalPenjualan }}</h2>
        </div>
        <div class="kpi-card">
            <span>Total Transaksi</span>
            <h2>{{ $totalTransaksi }}</h2>
        </div>
        <div class="kpi-card">
            <span>Total Seller</span>
            <h2>{{ $totalSeller }}</h2>
        </div>
        <div class="kpi-card">
            <span>Total Pendapatan</span>
            <h2>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
        </div>
    </div>

 {{-- TOP SELLER --}}
    <div class="chart-box" style="margin-bottom: 40px;">
        <h3>Top Seller</h3>
        
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="text-align:left; color:#6b7280;">
                    <th>Rank</th>
                    <th>Nama Seller</th>
                    <th>Total Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topSellers as $index => $row)
                    <tr style="border-top:1px solid #e5e7eb;">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->seller->name ?? '-' }}</td>
                        <td>
                            Rp {{ number_format($row->total, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- GRAFIK BULANAN -->
    <div class="chart-grid">
        <div class="chart-box">
            <h3 style="margin-bottom:20px">Grafik Penjualan Bulanan</h3>
            <canvas id="monthlyChart" height="120"></canvas>
        </div>

        <!-- GRAFIK KATEGORI -->
        <div class="chart-box">
            <h3 style="margin-bottom:20px">Grafik Penjualan per Kategori</h3>
            <canvas id="categoryChart" height="120"></canvas>
        </div>
        
        <!-- GRAFIK PRODUK PALING LAKU -->
        <div class="chart-box">
            <h3 style="margin-bottom:20px">Produk Paling Laku</h3>
            <canvas id="topProductsChart" height="120"></canvas>
        </div>

        <!-- GRAFIK METODE PEMBAYARAN -->
        <div class="chart-box">
            <h3 style="margin-bottom:20px">Metode Pembayaran</h3>
            <canvas id="paymentMethodsChart" height="120"></canvas>
        </div>
    </div>
    
    <script>

    const monthlyLabels = [
        'Jan','Feb','Mar','Apr','Mei','Jun',
        'Jul','Agu','Sep','Okt','Nov','Des'
    ];

    const monthlyData = {!! json_encode(array_values($monthlySales)) !!};

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                data: monthlyData,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.15)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                        }
                }
            }
        }
    });

    const categoryLabels = {!! json_encode(array_keys($salesByCategory)) !!};
    const categoryData   = {!! json_encode(array_values($salesByCategory)) !!};

    new Chart(document.getElementById('categoryChart'), {
        type: 'line',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: 'rgba(99,102,241,0.85)',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });
    
    fetch('/dashboard/top-products')
    .then(res => res.json())
    .then(data => {
        const values = data.map(d => d.qty);
        const labels = data.map(d => d.name);  
        
        new Chart(document.getElementById('topProductsChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderRadius: 8,
                }]
            },
            
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });                                                                                                                       
    });

    // Fetch payment methods data and create line chart
    fetch('/dashboard/payment-methods')
    .then(res => res.json())
    .then(data => {
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const datasets = [];
        const colors = ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 205, 86, 0.8)'];
        let colorIndex = 0;

        for (const [method, values] of Object.entries(data)) {
            datasets.push({
                label: method,
                data: Object.values(values),
                borderColor: colors[colorIndex % colors.length],
                backgroundColor: colors[colorIndex % colors.length].replace('0.8', '0.1'),
                fill: false,
                tension: 0.4
            });
            colorIndex++;
        }

        new Chart(document.getElementById('paymentMethodsChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    });
    
    
    </script>
    </body>
    </html>
 