<?php

namespace App\Exports;

use App\Models\Seller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SellersExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Seller::query();

        if ($this->request->filled('search')) {
            $search = $this->request->search;

            $query->where('name', 'LIKE', "%$search%")
                  ->orWhere('id_seller', 'LIKE', "%$search%");
        }

        return $query->select(
            'id_seller',
            'name',
            'alamat',
            'domisili',
            'no_telpon',
            'product_knowledge',
            'skema_penjualan',
            'mou'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID Seller',
            'Nama',
            'Alamat',
            'Domisili',
            'No Telepon',
            'Product Knowledge',
            'Skema Penjualan',
            'MoU',
        ];
    }
}   
