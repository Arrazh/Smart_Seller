<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Seller</title>

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
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 50px;
            background: #ffffff;
            overflow-y: auto;
        }

        .content h1 {
            text-align: center;
            margin-bottom: 70px;
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
            <a href="{{ route('aktivitas') }}">Aktivitas Seller</a> 
            <a href="{{ route('dbpenjualan') }}">Database Penjualan</a>
        </div>

        <a href="#" class="logout-btn">Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h1>Data Seller</h1>

        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
        <a href="{{ route('aktivitas') }}" class="btn btn-green"style="display:flex; align-items:center; justify-content:center; width:45px; padding:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 6L9 12L15 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <a href="{{ route('data.seller.export') }}" class="btn btn-blue">Export Excel </a>


            <div class="search-box">
                <input type="text" placeholder="Search">
            </div>
        </div>

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>ID Seller</th>
                    <th>Alamat</th>
                    <th>Domisili</th>
                    <th>No Telpon</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sellers as $seller)
                <tr>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->id_seller }}</td>
                    <td>{{ $seller->alamat }}</td>
                    <td>{{ $seller->domisili }}</td>
                    <td>{{ $seller->no_telpon }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>
