<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Database Penjualan | Smart Seller</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:'Poppins', sans-serif
    }

    body{
        display:flex;
        min-height:100vh;
        background:#f3f4f6;
        color:#333
    }

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

    .menu a{
        color:#fff;
        text-decoration:none;
        padding:14px 30px;
        margin:8px 20px;
        border-radius:12px;
        display:block;
    }

    .menu a.active,.menu a:hover{background:rgba(255,255,255,.25)}

    .logout-btn{
        margin-top:auto;
        margin-bottom:25px;
        background:linear-gradient(135deg,#ef4444,#dc2626);
        padding:12px 50px;
        border-radius:10px;
        color:#fff;
        text-decoration:none;
    }

    /* CONTENT */
    .content{
        flex:1;
        padding:40px;
        background:#fff;
        margin-left:260px
    }

    .h1{
        text-align:center;
        margin-bottom:10px
    }


    .btn-green,.btn-blue,.btn-yellow,.btn-gray, .btn-red{
        padding:8px 16px;border-radius:8px;border:none;
        color:#fff;font-weight:500;cursor:pointer
    }

    .btn-green{background:#22c55e}
    .btn-blue{background:#3b82f6}
    .btn-yellow{background:#f59e0b}
    .btn-gray{background:#6b7280}
    .btn-red{background:#ef4444}

    .search-box{
        background:#e5e7eb;
        padding:10px 15px;
        border-radius:8px;
        width:200px
    }

    .search-box input{
        border:none;
        background:none;
        outline:none;
        width:100%
    }

    .status-dropdown{
        padding:8px 12px;
        border-radius:6px;
        border:1px solid #d1d5db
    }

    table{
        width:100%;
        margin-top:20px;
        border-collapse:collapse
    }

    thead{
        background:#1e3a8a;
        color:#fff}

    th,td{
        padding:14px;
        border-bottom:1px solid #d1d5db;
        text-align:center
    }

    .radio-col{
        display:none
    }

    .update-mode .radio-col{
        display:table-cell
    }

    .update-mode .status-dropdown{
        opacity:.6;
        pointer-events:none
    }

    .delete-col {
        display:none
    }
    .delete-mode .delete-col {
        display:table-cell
    }

    .delete-mode .radio-col {
        display:none
    }

    .row-selected{
        background:#fef3c7
    }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Smart Seller</h2>

    <div class="menu">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('aktivitas') }}">Aktivitas Seller</a>
        <a class="active" href="{{ route('dbpenjualan') }}">Database Penjualan</a>
    </div>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit();"
       class="logout-btn">Logout</a>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
        @csrf
    </form>
</div>

<div class="content">
<h1 style="text-align: center; margin-bottom: 40px;">Laporan Penjualan</h1>

<!-- ACTION BAR -->
<div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px">
    <a href="{{ route('seller.sales.add') }}"><button class="btn-green">+ Tambah Penjualan</button></a>
    <a href="{{ route('dbpenjualan.export') }}"><button class="btn-blue">Export Excel</button></a>

    <button id="btnUpdate" class="btn-yellow">Update</button>
    <button id="btnCancel" class="btn-gray" style="display:none">Batal</button>
    <button id="btnEdit" class="btn-blue" style="display:none" disabled>Edit Data</button>

    <button id="btnDelete" class="btn-red">Delete</button>
    <button id="btnDeleteConfirm" class="btn-red" style="display:none">Hapus Terpilih</button>


    <!-- FILTER (UTUH) -->
    <form method="GET" action="{{ route('dbpenjualan') }}"
          style="display:flex;flex-wrap:wrap;gap:10px;align-items:center">
        <div class="search-box">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search">
        </div>

        <select name="range" class="status-dropdown" onchange="this.form.submit()">
            <option value="">-- Rentang Waktu --</option>
            <option value="1hari" {{ request('range')=='1hari'?'selected':'' }}>1 Hari</option>
            <option value="1minggu" {{ request('range')=='1minggu'?'selected':'' }}>1 Minggu</option>
            <option value="1bulan" {{ request('range')=='1bulan'?'selected':'' }}>1 Bulan</option>
        </select>

        <select name="category" class="status-dropdown" onchange="this.form.submit()">
            <option value="">-- Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <select name="metode" class="status-dropdown" onchange="this.form.submit()">
            <option value="">-- Metode Pembayaran --</option>
            <option value="cash" {{ request('metode')=='cash'?'selected':'' }}>Cash</option>
            <option value="transfer" {{ request('metode')=='transfer'?'selected':'' }}>Transfer</option>
            <option value="qris" {{ request('metode')=='qris'?'selected':'' }}>QRIS</option>
        </select>
        <select name="status" class="status-dropdown" onchange="this.form.submit()">
            <option value="">-- Status --</option>
            <option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option>
            <option value="belum_lunas" {{ request('status')=='belum_lunas'?'selected':'' }}>Belum Lunas</option>
        </select>
    </form>
</div>

<form id="deleteForm" method="POST" action="{{ route('seller.sales.bulkDelete') }}">
    @csrf
    @method('DELETE')
</form>

<table id="salesTable">
<thead>
<tr>
    <th class="radio-col">Pilih</th>
    <th class="delete-col">Hapus</th>
    <th>Tanggal</th>
    <th>Nama Seller</th>
    <th>Kategori</th>
    <th>Black Garlic 100g</th>
    <th>Black Garlic 150g</th>
    <th>Muli Water pH Tinggi</th>
    <th>Muli Water pH 9+</th>
    <th>Total Harga</th>
    <th>Metode</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
@foreach($sales as $sale)
<tr data-id="{{ $sale->id }}">
    <td class="radio-col">
        <input type="radio" name="selected_sale" value="{{ $sale->id }}">
    </td>
    <td class="delete-col">
        <input type="checkbox" name="delete_ids[]" value="{{ $sale->id }}" form="deleteForm">
    </td>
    <td>{{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}</td>
    <td>{{ $sale->seller->name }}</td>
    <td>{{ $sale->category }}</td>
    <td>{{ $sale->qty_blackgarlic_100g }}</td>
    <td>{{ $sale->qty_blackgarlic_150g }}</td>
    <td>{{ $sale->qty_muliwater_ph_tinggi }}</td>
    <td>{{ $sale->qty_muliwater_ph9 }}</td>
    <td>Rp {{ number_format($sale->total_price,0,',','.') }}</td>
    <td>{{ ucfirst($sale->metode_pembayaran) }}</td>
    <td>{{ ucfirst(str_replace('_', ' ', $sale->status)) }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<script>
const table = document.getElementById('salesTable');

const btnUpdate = document.getElementById('btnUpdate');
const btnDelete = document.getElementById('btnDelete');
const btnCancel = document.getElementById('btnCancel');
const btnEdit = document.getElementById('btnEdit');
const btnDeleteConfirm = document.getElementById('btnDeleteConfirm');

const radios = document.querySelectorAll('input[name="selected_sale"]');
const deleteForm = document.getElementById('deleteForm');

// === UPDATE MODE ===
btnUpdate.onclick = () => {
    table.classList.add('update-mode');
    table.classList.remove('delete-mode');

    btnUpdate.style.display = 'none';
    btnDelete.style.display = 'none';

    btnCancel.style.display = 'inline-block';
    btnEdit.style.display = 'inline-block';
    btnDeleteConfirm.style.display = 'none';
};

// === DELETE MODE ===
btnDelete.onclick = () => {
    table.classList.add('delete-mode');
    table.classList.remove('update-mode');

    btnUpdate.style.display = 'none';
    btnDelete.style.display = 'none';

    btnCancel.style.display = 'inline-block';
    btnEdit.style.display = 'none';
    btnDeleteConfirm.style.display = 'inline-block';
};

// === CANCEL ===
btnCancel.onclick = () => {
    table.classList.remove('update-mode', 'delete-mode');

    btnUpdate.style.display = 'inline-block';
    btnDelete.style.display = 'inline-block';

    btnCancel.style.display = 'none';
    btnEdit.style.display = 'none';
    btnEdit.disabled = true;
    btnDeleteConfirm.style.display = 'none';

    radios.forEach(r => r.checked = false);
    document.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);
    document.querySelectorAll('tr').forEach(tr => tr.classList.remove('row-selected'));
};

// === RADIO SELECT ===
radios.forEach(radio => {
    radio.onchange = () => {
        btnEdit.disabled = false;
        document.querySelectorAll('tr').forEach(tr => tr.classList.remove('row-selected'));
        radio.closest('tr').classList.add('row-selected');
    };
});

// === EDIT ===
btnEdit.onclick = () => {
    const selected = document.querySelector('input[name="selected_sale"]:checked');
    if (!selected) return;
    if (!confirm('Yakin ingin mengedit data ini?')) return;
    window.location.href = `/seller/sales/${selected.value}/edit`;
};

// === DELETE CONFIRM ===
btnDeleteConfirm.onclick = () => {
    const checked = document.querySelectorAll('input[name="delete_ids[]"]:checked');
    if (checked.length === 0) {
        alert('Pilih minimal satu data');
        return;
    }
    if (confirm(`Hapus ${checked.length} data?`)) {
        deleteForm.submit();
    }
};
</script>

</body>
</html>