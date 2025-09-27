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

    // Enhanced accessor for 'total' (dynamic based on type and product)
    public function getTotalAttribute()
    {
        if ($this->type === 'income' && $this->product) {
            // For income (e.g., sales): quantity * sell_price
            return $this->quantity * ($this->product->sell_price ?? $this->amount);
        } elseif ($this->type === 'expense' && $this->product) {
            // For expense (e.g., purchases): quantity * buy_price or just amount
            return $this->quantity * ($this->product->buy_price ?? $this->amount);
        }
        
        // Fallback: just amount (or 0 if null)
        return $this->amount ?? 0;
    }

    // Optional: Accessor for formatted total (e.g., for direct use in views)
    public function getFormattedTotalAttribute()
    {
        return 'Rp' . number_format($this->total, 0, ',', '.');
    }
}