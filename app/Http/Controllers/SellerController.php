<?php
namespace App\Http\Controllers;

use App\Models\Seller;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use App\Exports\DataSellerExport;
use App\Exports\SellersExport;
use Maatwebsite\Excel\Facades\Excel;

class SellerController extends Controller
{
    // halaman tabel aktivitas seller
    public function index(Request $request)
    {
        $query = Seller::query();

        if($request->filled('search')) {
        $search = $request->search;
            
        $query->where('name', 'LIKE', "%$search%")
              ->orWhere('id_seller', 'LIKE', "%$search%");
        }   

        $sellers = $query->get();

        return view('aktivitas', compact('sellers'));
    }

    // halaman form tambah seller
    public function create()
    {
        return view('add_seller');
    }

    // simpan seller
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id_seller' => 'required|unique:sellers',
        ]);

        Seller::create([
            'name' => $request->name,
            'id_seller' => $request->id_seller,
            'alamat' => $request->alamat,
            'domisili' => $request->domisili,
            'no_telpon' => $request->no_telpon,
        ]);

        return redirect()->route('aktivitas')->with('success', 'Seller berhasil ditambahkan');
    }

        public function toggle(Seller $seller, $field)
    {
        if (!in_array($field, ['product_knowledge', 'skema_penjualan', 'mou'])) {
            abort(400, 'Invalid field');
        }

        $seller->$field = !$seller->$field;
        $seller->save();

        return back();
    }
    public function data()
    {
        $sellers = Seller::all();
        return view('data_seller', compact('sellers'));
    }

    public function export(Request $request)
    {
        return Excel::download(new \App\Exports\SellersExport($request), 'sellers.xlsx');
    }

    public function exportDataSeller()
    {
        return Excel::download(new \App\Exports\DataSellerExport, 'data_seller.xlsx');
    }
}   
