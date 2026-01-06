<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas Seller</title>

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

        /* KONTEN UTAMA */
        .content {
            flex: 1;
            padding: 50px;
            background: #ffffff;
            overflow-y: auto;
        }

        .content h1 {
            text-align: center;
            margin-top: 0%;
            margin-bottom: 100px;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            color: white;
        }

        .btn-green {
            background: #22c55e;
        }

        .btn-blue {
            background: #3b82f6;
        }

        /* SEARCH BOX */
        .search-box {
            margin-left: auto;
            background: #f3f4f6;
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            width: 260px;
        }

        .search-box input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background: #1e3a8a;
            color: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            text-align: center;
        }

        td:first-child {
            text-align: left;
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

        .logout-btn:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
        }

        a.btn {
            text-decoration: none;
        }

    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Smart Seller</h2>

        <div class="menu">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="#" class="active">Aktivitas Seller</a>
            <a href="{{ route('dbpenjualan') }}">Database Penjualan</a>
        </div>

        <a href="#" class="logout-btn">Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h1>Aktivitas Seller</h1>

        <!-- TOMBOL DAN SEARCH -->
        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <a href="{{ route('add_seller') }}" class="btn btn-green">+ Tambah Seller</a>
            <a href="{{ route('data.seller') }}"class="btn btn-green">Data Seller</a>
            <a href="{{ route('aktivitas.export') }}" class="btn btn-blue">Export Excel</a>
            
        <form action="{{ route('aktivitas') }}" method="GET" style="margin-left: auto;">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
            </div>
            </div>  
        </form>     

        <!-- TABEL -->
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Product Knowledge</th>
                    <th>Skema Penjualan</th>
                    <th>MoU</th>
                    <th>Black Garlic</th>
                    <th>Muli Water</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sellers as $seller)
            
                <tr>
                    <td>{{ $seller->name }}</td>
                    <td style="text-align:center;">
                        <input type="checkbox"
                            onchange="document.getElementById('pk-{{ $seller->id }}').submit()"
                            {{ $seller->product_knowledge ? 'checked' : '' }}>
                        
                        <form id="pk-{{ $seller->id }}" 
                            action="{{ route('seller.toggle', [$seller->id, 'product_knowledge']) }}" 
                            method="POST" style="display:none;">
                            @csrf
                            @method('PATCH')
                        </form>
                    </td>

                    <td style="text-align:center;">
                        <input type="checkbox"
                            onchange="document.getElementById('sp-{{ $seller->id }}').submit()"
                            {{ $seller->skema_penjualan ? 'checked' : '' }}>
                        
                        <form id="sp-{{ $seller->id }}" 
                            action="{{ route('seller.toggle', [$seller->id, 'skema_penjualan']) }}" 
                            method="POST" style="display:none;">
                            @csrf
                            @method('PATCH')
                        </form>
                    </td>

                    <td style="text-align:center;">
                        <input type="checkbox"
                            onchange="document.getElementById('mou-{{ $seller->id }}').submit()"
                            {{ $seller->mou ? 'checked' : '' }}>
                        
                        <form id="mou-{{ $seller->id }}" 
                            action="{{ route('seller.toggle', [$seller->id, 'mou']) }}" 
                            method="POST" style="display:none;">
                            @csrf
                            @method('PATCH')
                        </form>
                    </td>
                    <td style="text-align:center;">Rp 35.000</td>
                    <td style="text-align:center;">Rp 37.500</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>
