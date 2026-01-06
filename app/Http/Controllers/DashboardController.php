<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. DAFTAR KATEGORI
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
            'Mahasiswa',
            'Mitra PLJ',
        ];

        // 2. MENGAMBIL DATA PENJUALAN YANG ADA
        $salesFromDb = Sale::selectRaw('
                category,
                SUM(qty_blackgarlic + qty_muliwater) as total
            ')
            ->whereNotNull('category')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // 3. GABUNGKAN → YANG GA ADA = 0
        $finalData = [];
        foreach ($allCategories as $category) {
            $finalData[$category] = $salesFromDb[$category] ?? 0;
        }

        return view('dashboard', [
            'salesData' => $finalData
        ]);
    }
}
