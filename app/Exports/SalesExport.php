<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Sale::with('seller');

        // FILTER RANGE
        if ($this->request->filled('range')) {
            switch ($this->request->range) {
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

        // FILTER KATEGORI
        if ($this->request->filled('category')) {
            $query->where('category', $this->request->category);
        }

        // FILTER METODE
        if ($this->request->filled('metode')) {
            $query->where('metode_pembayaran', $this->request->metode);
        }

        // FILTER STATUS
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        // SEARCH SELLER
        if ($this->request->filled('search')) {
            $query->whereHas('seller', function ($q) {
                $q->where('name', 'like', '%' . $this->request->search . '%');
            });
        }

        return $query->get()->map(function ($sale) {
            return [
                $sale->tanggal,
                $sale->seller->name ?? '-',
                $sale->category,
                $sale->qty_blackgarlic,
                $sale->qty_muliwater,
                $sale->total_price,
                ucfirst($sale->metode_pembayaran),
                ucfirst(str_replace('_', ' ', $sale->status)),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Seller',
            'Kategori',
            'Qty Black Garlic',
            'Qty Muli Water',
            'Total Harga',
            'Metode Pembayaran',
            'Status',
        ];
    }
}
