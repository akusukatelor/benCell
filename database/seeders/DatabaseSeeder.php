<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123')
        ]);

        // Tambah kategori
        $kategori = Category::create(['name' => 'Aksesoris HP']);

        // Tambah produk
        $produk = Product::create([
            'category_id' => $kategori->id,
            'name' => 'Charger Original',
            'sku' => 'CH001',
            'stock' => 10,
            'cost_price' => 25000,
            'sell_price' => 50000
        ]);

        // Tambah transaksi
        Transaction::create([
            'type' => 'income',
            'product_id' => $produk->id,
            'quantity' => 1,
            'amount' => 50000,
            'note' => 'Penjualan pertama',
            'date' => now(),
        ]);

        // Tambah service
        ServiceOrder::create([
            'customer_name' => 'Budi',
            'customer_phone' => '08123456789',
            'device' => 'Samsung A10',
            'problem' => 'Layar pecah',
            'status' => 'incoming',
            'estimated_cost' => 250000,
        ]);
    }
}
