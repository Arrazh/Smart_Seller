<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class SalesController extends Controller
{
    // Form tambah penjualan
    public function create()
    {
        $sellers = Seller::all();
        return view('add_sales', compact('sellers'));
    }

    // Simpan penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'qty_blackgarlic' => 'required|integer|min:0',
            'qty_muliwater' => 'required|integer|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
            'status' => 'required|in:lunas,belum_lunas',
        ]);

        // harga fix
        $price_black = 35000;
        $price_muli  = 37500;

        $total = ($request->qty_blackgarlic * $price_black) +
                 ($request->qty_muliwater * $price_muli);

        Sale::create([
            'seller_id' => $request->seller_id,
            'qty_blackgarlic' => $request->qty_blackgarlic,
            'qty_muliwater' => $request->qty_muliwater,
            'total_price' => $total,
            'category' => $request->category,
            'tanggal' => $request->tanggal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Penjualan berhasil ditambahkan!');
    }

    // Update status pembayaran
    public function updateStatus(Request $request, Sale $sale)
    {
        $request->validate([
            'status' => 'required|in:lunas,belum_lunas'
        ]);

        $sale->status = $request->status;
        $sale->save([
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    // Index dengan filter & search
    public function index(Request $request)
    {
        $query = Sale::with('seller');

        // Filter range waktu
        if ($request->filled('range')) {
            switch ($request->range) {
                case '1hari':
                    $query->whereDate('tanggal', now());
                    break;
                case '1minggu':
                    $query->whereBetween('tanggal', [now()->subDays(6), now()]);
                    break;
                case '1bulan':
                    $query->whereBetween('tanggal', [now()->subMonth(), now()]);
                    break;
            }
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter metode pembayaran
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search nama seller
        if ($request->filled('search')) {
            $query->whereHas('seller', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }

        $sales = $query->latest()->get();

        // Ambil semua kategori unik untuk dropdown
        $categories = Sale::select('category')->distinct()->pluck('category');

        return view('dbpenjualan', compact('sales', 'categories', 'request'));
    }

    public function export(Request $request)
    {
        return Excel::download(new SalesExport($request), 'db_penjualan.xlsx');
    }
}