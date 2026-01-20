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


    return $query->get()->map(function ($seller) {
        return [
            $seller->id_seller,
            $seller->name,
            $seller->alamat,
            $seller->domisili,
            $seller->no_telpon,
            $seller->product_knowledge ? 'YA' : 'TIDAK',
            $seller->skema_penjualan ? 'YA' : 'TIDAK',
            $seller->mou ? 'YA' : 'TIDAK',
            35000,
            52500,
            37500,
            42500,
        ];
    });
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
            'Black Garlic 100g',
            'Black Garlic 150g',
            'Muli Water pH Tinggi',
            'Muli Water pH 9+'
        ];
    }                                                                                       
}   
