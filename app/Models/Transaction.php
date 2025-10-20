<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',       // income | expense
        'product_id', // nullable
        'service_order_id',
        'amount',
        'quantity',
        'note',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime',  // Now preserves time (format: Y-m-d H:i:s)
        'amount' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function serviceOrder()
    {
    return $this->belongsTo(ServiceOrder::class);
    }


    // Enhanced accessor for 'total' (dynamic based on type and product)
   public function getTotalAttribute()
{
    if ($this->type === 'income' && $this->product) {
        return $this->quantity * ($this->product->sell_price ?? $this->amount);
    } elseif ($this->type === 'expense' && $this->product) {
        return $this->quantity * ($this->product->cost_price ?? $this->amount); // <-- ganti buy_price -> cost_price
    } elseif ($this->type === 'income_service') {
        return $this->amount; // langsung pakai amount
    }

    return $this->amount ?? 0;
}


    // Optional: Accessor for formatted total (e.g., for direct use in views)
    public function getFormattedTotalAttribute()
    {
        return 'Rp' . number_format($this->total, 0, ',', '.');
    }
}