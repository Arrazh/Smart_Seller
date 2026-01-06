<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Penjualan</title>

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
    background: linear-gradient(180deg,#1e3a8a 0%,#7c3aed 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 0;
    box-shadow: 4px 0 20px rgba(0,0,0,0.15);
    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 100%;
}

.content{
    margin-left: 260px;
}

.sidebar h2 {
    font-weight: 700;
    font-size: 1.6rem;
    color: #fff;
    margin-bottom: 50px;
    text-shadow: 0 0 10px rgba(255,255,255,0.3);
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
    transition: 0.3s;
    font-weight: 500;
    display: block;
}
.menu a:hover,
.menu a.active {
    background: rgba(255,255,255,0.25);
    box-shadow: 0 4px 12px rgba(124,58,237,0.3);
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
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(220,38,38,0.4);
}
.logout-btn:hover {
    opacity: 0.9;
}

/* CONTENT */
.content {
    flex: 1;
    padding: 40px;
    background: white;
    overflow-y: auto;
}
h1 {
    text-align: center;
    margin-bottom: 30px;
}

/* FORM MODERN */
.form-group {
    margin-bottom: 20px;
}
label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #1f2937;
}
input, select {
    width: 100%;
    padding: 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    font-size: 1rem;
    color: #111827;
}
input::placeholder, select option {
    color: #9ca3af;
}
input:focus, select:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 6px 15px rgba(124,58,237,0.2);
    transform: translateY(-2px);
}
input:hover, select:hover {
    border-color: #7c3aed;
    box-shadow: 0 4px 12px rgba(124,58,237,0.15);
    transform: translateY(-1px);
}

/* BUTTONS */
.btn-submit {
    padding: 14px 24px;
    border: none;
    border-radius: 12px;
    background: #22c55e;
    color: white;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease, transform 0.1s ease;
}
.btn-submit:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(34,197,94,0.3);
}
.back-wrapper .btn-back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 12px;
    background: #22c55e;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease, transform 0.1s ease;
}
.back-wrapper .btn-back:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(22,163,74,0.3);
}

/* RESPONSIVE */
@media(max-width: 768px){
    body {
        flex-direction: column;
    }
    .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        padding: 20px 0;
    }
    .menu a {
        margin: 0 10px;
    }
    .content {
        padding: 20px;
    }
}
</style>

</head>
<body>

<div class="sidebar">
    <h2>Smart Seller</h2>

    <div class="menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('aktivitas') }}" class="{{ request()->routeIs('aktivitas') ? 'active' : '' }}">Aktivitas Seller</a>
        <a href="{{ route('dbpenjualan') }}" class="{{ request()->routeIs('dbpenjualan') ? 'active' : '' }}">Database Penjualan</a>
    </div>

    <a href="#" class="logout-btn">Logout</a>
</div>

<div class="content">

    <h1>Input Penjualan</h1>

    <div class="back-wrapper">
        <a href="{{ route('dbpenjualan') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M15 6L9 12L15 18" stroke="white" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>

    <form action="{{ route('seller.sales.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" required placeholder="Pilih tanggal">
        </div>

        <div class="form-group">
            <label>Pilih Seller</label>
            <select name="seller_id" required>
                <option value="">-- Pilih Seller --</option>
                @foreach ($sellers as $seller)
                    <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Black Garlic (Rp 35.000)</label>
            <input type="number" name="qty_blackgarlic" min="0" required placeholder="Masukkan jumlah">
        </div>

        <div class="form-group">
            <label>Muli Water (Rp 37.500)</label>
            <input type="number" name="qty_muliwater" min="0" required placeholder="Masukkan jumlah">
        </div>

        <div class="form-group">
            <label>Kategori Pembeli</label>
            <select name="category" required>
                <option value="Dosen">Dosen</option>
                <option value="Perusahaan">Perusahaan</option>
                <option value="Alumni">Alumni</option>
                <option value="Penjualan Online">Penjualan Online</option>
                <option value="Koperasi">Koperasi</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Agen Baru Karyawan">Agen Baru Karyawan</option>
                <option value="Mitra Komunitas">Mitra Komunitas</option>
                <option value="Mitra Sekolah">Mitra Sekolah</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Mitra Pemerintah">Mitra Pemerintah</option>
                <option value="Mitra PLJ">Mitra PLJ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" required>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer Bank</option>
                <option value="qris">QRIS</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Status Pembayaran</label>
            <select name="status" required>
            <option value="">Pilih Status</option>
            <option value="lunas">Lunas</option>
            <option value="belum_lunas">Belum Lunas</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Simpan Penjualan</button>
    </form>

</div>

</body>
</html>
