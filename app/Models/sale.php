<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'seller_id',
        'qty_blackgarlic',
        'qty_muliwater',
        'category',
        'total_price',
        'tanggal',
        'metode_pembayaran',
        'status',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
