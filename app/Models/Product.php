<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Product extends Model {
use HasFactory;
protected $fillable = [
        'name',
        'sku',
        'stock',
        'cost_price',
        'sell_price',
        'category_id'
    ];

public function decrementStock($qty = 1)
{
    if ($this->stock >= $qty) {
        $this->stock -= $qty;
        $this->save();
        return true; // sukses
    }
    return false; // gagal karena stok habis
}


public function category(){
return $this->belongsTo(Category::class);
}
}