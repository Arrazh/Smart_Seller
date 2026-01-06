<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'id_seller', 
        'alamat', 
        'domisili', 
        'no_telpon',
        'product_knowledge', 
        'skema_penjualan', 
        'mou'
    ];

}
