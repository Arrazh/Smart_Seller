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
    public function create()
    {
        return view('add_sales', [
            'sellers' => Seller::all(),
            'mode' => 'create',
            'sale' => null
        ]);
    }

    public function edit(Sale $sale)
    {
        return view('add_sales', [
            'sellers' => Seller::all(),
            'mode' => 'edit',
            'sale' => $sale
        ]);
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->back()
            ->with('success', 'Data Penjualan Berhasil Dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->delete_ids;
        
        if (!$ids || count($ids) === 0) {
            return back()->with('error', 'Tidak ada data dipilih');
        }

        Sale::whereIn('id', $ids)->delete();

        return redirect()
            ->route('dbpenjualan')
            ->with('success', count($ids).' data berhasil dihapus');
    }

    public function store(Request $request)
    {
        // Ensure quantity fields have default values of 0 if not provided
        $request->merge([
            'qty_blackgarlic_100g' => $request->qty_blackgarlic_100g ?? 0,
            'qty_blackgarlic_150g' => $request->qty_blackgarlic_150g ?? 0,
            'qty_muliwater_ph_tinggi' => $request->qty_muliwater_ph_tinggi ?? 0,
            'qty_muliwater_ph9' => $request->qty_muliwater_ph9 ?? 0,
        ]);

        $data = $this->validateData($request);
        $data['total_price'] = $this->hitungTotal($request);

        Sale::create($data);

        return redirect()
            ->route('dbpenjualan')
            ->with('success', 'Penjualan berhasil ditambahkan!');
    }

    public function update(Request $request, Sale $sale)
    {
        // Ensure quantity fields have default values of 0 if not provided
        $request->merge([
            'qty_blackgarlic_100g' => $request->qty_blackgarlic_100g ?? 0,
            'qty_blackgarlic_150g' => $request->qty_blackgarlic_150g ?? 0,
            'qty_muliwater_ph_tinggi' => $request->qty_muliwater_ph_tinggi ?? 0,
            'qty_muliwater_ph9' => $request->qty_muliwater_ph9 ?? 0,
        ]);

        $data = $this->validateData($request);
        $data['total_price'] = $this->hitungTotal($request);

        $sale->update($data);

        return redirect()
            ->route('dbpenjualan')
            ->with('success', 'Penjualan berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Sale $sale)
    {
        $request->validate([
            'status' => 'required|in:lunas,belum_lunas'
        ]);

        $sale->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function index(Request $request)
    {
        $query = Sale::with('seller');

        if ($request->filled('range')) {
            match ($request->range) {
                '1hari' => $query->whereDate('tanggal', now()),
                '1minggu' => $query->whereBetween('tanggal', [now()->subDays(6), now()]),
                '1bulan' => $query->whereBetween('tanggal', [now()->subMonth(), now()]),
                default => null
            };
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('seller', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        return view('dbpenjualan', [
            'sales' => $query->latest()->get(),
            'categories' => Sale::select('category')->distinct()->pluck('category'),
            'request' => $request
        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(new SalesExport($request), 'db_penjualan.xlsx');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'tanggal' => 'required|date',
            'seller_id' => 'required|exists:sellers,id',
            'qty_blackgarlic_100g' => 'required|integer|min:0',
            'qty_blackgarlic_150g' => 'required|integer|min:0',
            'qty_muliwater_ph_tinggi' => 'required|integer|min:0',
            'qty_muliwater_ph9' => 'required|integer|min:0',
            'category' => 'required|string',
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
            'status' => 'required|in:lunas,belum_lunas',
        ]);
    }

    private function hitungTotal(Request $request)
    {
        return ($request->qty_blackgarlic_100g * 35000)
             + ($request->qty_blackgarlic_150g * 52500)
             + ($request->qty_muliwater_ph_tinggi * 37500)
             + ($request->qty_muliwater_ph9 * 42500);
    }
}
