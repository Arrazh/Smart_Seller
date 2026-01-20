<?php 

namespace App\Models; 

use Illuminate\Database\Eloquent\Model; 

class Sale extends Model 
{ 
    protected $fillable = 
    [ 
        'seller_id', 
        'qty_blackgarlic_100g', 
        'qty_blackgarlic_150g', 
        'qty_muliwater_ph_tinggi', 
        'qty_muliwater_ph9', 
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