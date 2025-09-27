<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('product')->latest()->paginate(10);  // Paginate instead of get()
        return view('transactions.index', compact('transactions'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();  // Pass produk untuk select di form
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:income,expense',
            'product_name' => 'required|string|exists:products,name',  // Validasi nama dari form
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
            'note'   => 'nullable|string|max:255',
        ]);

        // Cari produk berdasarkan nama dari form
        $product = Product::where('name', $request->product_name)->firstOrFail();

        // Buat transaksi dengan product_id
        Transaction::create([
            'type' => $request->type,
            'product_id' => $product->id,  // Simpan ID produk
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'date' => Carbon::parse($request->date),  // Parse date untuk format yang aman
            'note' => $request->note,
        ]);

        // Update stok berdasarkan type
        if ($request->type === 'income') {
            // Income: Penjualan, kurangi stok
            $product->decrement('stock', $request->quantity);
        } elseif ($request->type === 'expense') {
            // Expense: Pembelian, tambah stok
            $product->increment('stock', $request->quantity);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $products = Product::all();  // Pass produk untuk select di form edit
        return view('transactions.edit', compact('transaction', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'type'   => 'required|in:income,expense',
            'product_name' => 'required|string|exists:products,name',
            'quantity' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
            'note'   => 'nullable|string|max:255',
        ]);

        // Cari produk baru berdasarkan nama dari form
        $newProduct = Product::where('name', $request->product_name)->firstOrFail();

        // Rollback stok lama berdasarkan type lama
        $oldProduct = $transaction->product;  // Gunakan relasi untuk old product
        if ($oldProduct) {
            if ($transaction->type === 'income') {
                $oldProduct->increment('stock', $transaction->quantity);  // Kembalikan stok yang dikurangi
            } elseif ($transaction->type === 'expense') {
                $oldProduct->decrement('stock', $transaction->quantity);  // Kurangi stok yang ditambah
            }
        }

        // Update transaksi dengan data baru
        $transaction->update([
            'type' => $request->type,
            'product_id' => $newProduct->id,  // Update ke ID produk baru
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'date' => Carbon::parse($request->date),
            'note' => $request->note,
        ]);

        // Update stok baru berdasarkan type baru
        if ($request->type === 'income') {
            $newProduct->decrement('stock', $request->quantity);
        } elseif ($request->type === 'expense') {
            $newProduct->increment('stock', $request->quantity);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Rollback stok sebelum hapus
        $product = $transaction->product;  // Gunakan relasi
        if ($product) {
            if ($transaction->type === 'income') {
                $product->increment('stock', $transaction->quantity);  // Kembalikan stok penjualan
            } elseif ($transaction->type === 'expense') {
                $product->decrement('stock', $transaction->quantity);  // Kurangi stok pembelian
            }
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
    
}