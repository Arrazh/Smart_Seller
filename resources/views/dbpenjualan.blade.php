<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Penjualan | Smart Seller</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f3f4f6;
            color: #333;
        }

        /* SIDEBAR */
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
            display: block;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 40px;
            background: #ffffff;
            overflow-y: auto;
        }

        h1 {
            text-align: center;
            font-size: 1.9rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1f2937;
        }

        .line {
            width: 150px;
            height: 3px;
            background: #1f2937;
            margin: 5px auto 30px;
        }

        .btn-green {
            background: #22c55e;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-blue {
            background: #3b82f6;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: 500;
        }

        .search-box {
            background: #e5e7eb;
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            width: 200px;
        }

        .search-box input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
        }

        select.status-dropdown {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        thead {
            background: #1e3a8a;
            color: white;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #d1d5db;
            text-align: center;
            font-size: 1rem;
        }

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
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Smart Seller</h2>
        <div class="menu">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('aktivitas') }}">Aktivitas Seller</a>
            <a class="active" href="{{ route('dbpenjualan') }}">Database Penjualan</a>
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
        <h1>Laporan Penjualan</h1>
        <div class="line"></div>

        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 20px;">
            <a href="{{route('seller.sales.add')}}"><button class="btn-green">+ Tambah Penjualan</button></a>
            <a href="{{ route('dbpenjualan.export') }}"><button class="btn-blue">Export Excel</button></a>

            <!-- FILTER & SEARCH FORM -->
            <form method="GET" action="{{ route('dbpenjualan') }}" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                </div>

                <select name="range" class="status-dropdown" onchange="this.form.submit()">
                    <option value="">-- Rentang Waktu --</option>
                    <option value="1hari" {{ request('range')=='1hari' ? 'selected' : '' }}>1 Hari</option>
                    <option value="1minggu" {{ request('range')=='1minggu' ? 'selected' : '' }}>1 Minggu</option>
                    <option value="1bulan" {{ request('range')=='1bulan' ? 'selected' : '' }}>1 Bulan</option>
                </select>

                <select name="category" class="status-dropdown" onchange="this.form.submit()">
                    <option value="">-- Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category')==$cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <select name="metode" class="status-dropdown" onchange="this.form.submit()">
                    <option value="">-- Metode Pembayaran --</option>
                    <option value="cash" {{ request('metode')=='cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ request('metode')=='transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="qris" {{ request('metode')=='qris' ? 'selected' : '' }}>QRIS</option>
                </select>

                <select name="status" class="status-dropdown" onchange="this.form.submit()">
                    <option value="">-- Status --</option>
                    <option value="lunas" {{ request('status')=='lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum_lunas" {{ request('status')=='belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
            </form>
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Seller</th>
                    <th>Kategori</th>
                    <th>Black Garlic</th>
                    <th>Muli Water</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->tanggal ? \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') :'-'}}</td>
                    <td>{{ $sale->seller->name }}</td>
                    <td>{{ $sale->category }}</td>
                    <td>{{ $sale->qty_blackgarlic }}</td>
                    <td>{{ $sale->qty_muliwater }}</td> 
                    <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($sale->metode_pembayaran) }}</td>
                    <td>
                        <form action="{{ route('seller.sales.updateStatus', ['sale'=>$sale->id]) }}" method="POST">
                            @csrf 
                            @method('PATCH')
                            <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                <option value="lunas" {{ $sale->status=='lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum_lunas" {{ $sale->status=='belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>