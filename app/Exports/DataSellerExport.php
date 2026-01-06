<?php

namespace App\Exports;

use App\Models\Seller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataSellerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Seller::select(
            'name',
            'id_seller',
            'alamat',
            'domisili',
            'no_telpon'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'ID Seller',
            'Alamat',
            'Domisili',
            'No Telpon'
        ];
    }
}
