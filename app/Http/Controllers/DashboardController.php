<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * ===============================
         * 1. KPI CARDS
         * ===============================
         */

        $totalPenjualan = Sale::sum(
            DB::raw('qty_blackgarlic_100g + qty_blackgarlic_150g + qty_muliwater_ph_tinggi + qty_muliwater_ph9')
        );

        $totalTransaksi = Sale::count();

        $totalSeller = Sale::distinct('seller_id')->count('seller_id');

        $totalPendapatan = Sale::sum('total_price');
        
        $allCategories = [
            'Dosen',
            'Perusahaan',
            'Alumni',
            'Penjualan Online',
            'Koperasi',
            'Karyawan',
            'Agen Baru Karyawan',
            'Mitra Komunitas',
            'Mitra Sekolah',
            'Mitra Pemerintah',
            'Mitra PLJ',
            'Mahasiswa',
        ];

        $salesFromDb = Sale::selectRaw('
                category,
                SUM(qty_blackgarlic_100g + qty_blackgarlic_150g + qty_muliwater_ph_tinggi + qty_muliwater_ph9) as total
            ')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $salesByCategory = [];
        foreach ($allCategories as $category) {
            $salesByCategory[$category] = $salesFromDb[$category] ?? 0;
        }

        $monthlySales = Sale::selectRaw('
                MONTH(created_at) as bulan,
                SUM(qty_blackgarlic_100g + qty_blackgarlic_150g + qty_muliwater_ph_tinggi + qty_muliwater_ph9) as total
            ')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $bulanLengkap = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanLengkap[$i] = $monthlySales[$i] ?? 0;
        }

        $topSellers = Sale::selectRaw('seller_id, SUM(total_price) as total')
        ->whereNotNull('seller_id')
        ->groupBy('seller_id')
        ->orderByDesc('total')
        ->take(3)
        ->with('seller')
        ->get();
        
        return view('dashboard', [
            'totalPenjualan'   => $totalPenjualan,
            'totalTransaksi'   => $totalTransaksi,
            'totalSeller'      => $totalSeller,
            'totalPendapatan'  => $totalPendapatan,
            'salesByCategory'  => $salesByCategory,
            'monthlySales'     => $bulanLengkap,
            'topSellers'       => $topSellers,
        ]);   
    }
    
    public function topProducts()
    
    {
        $data = Sale::selectRaw('
        SUM(qty_blackgarlic_100g) as blackgarlic_100g,
        SUM(qty_blackgarlic_150g) as blackgarlic_150g,
        SUM(qty_muliwater_ph_tinggi) as muliwater_ph_tinggi,
        SUM(qty_muliwater_ph9) as muliwater_ph9
    ')
    ->where('created_at', '>=', now()->subDays(7))
    ->first();
    
    return response()->json([
        ['name' => 'Black Garlic 100g', 'qty' => (int) $data->blackgarlic_100g],
        ['name' => 'Black Garlic 150g', 'qty' => (int) $data->blackgarlic_150g],
        ['name' => 'Muli Water pH Tinggi', 'qty' => (int) $data->muliwater_ph_tinggi],
        ['name' => 'Muli Water pH 9+', 'qty' => (int) $data->muliwater_ph9],
    ]);
}

public function paymentMethods()
{
    $data = Sale::selectRaw('
        MONTH(created_at) as bulan,
        metode_pembayaran,
        COUNT(*) as count
    ')
    ->whereYear('created_at', now()->year)
    ->groupBy('bulan', 'metode_pembayaran')
    ->orderBy('bulan')
    ->get()
    ->groupBy('metode_pembayaran')
    ->map(function ($group) {
        return $group->pluck('count', 'bulan')->toArray();
    })
    ->toArray();

    // Pastikan semua bulan ada
    $allMonths = [];
    for ($i = 1; $i <= 12; $i++) {
        $allMonths[$i] = 0;
    }

    // Pastikan semua metode pembayaran ada (cash, transfer, qris)
    $allMethods = ['cash', 'transfer', 'qris'];

    $result = [];
    foreach ($allMethods as $method) {
        $months = isset($data[$method]) ? $data[$method] : [];
        $result[$method] = array_replace($allMonths, $months);
    }

    return response()->json($result);
}
}
