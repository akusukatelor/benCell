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
         $products = Product::all();
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
    public function update(Request $request, $id)
{
    $transaction = Transaction::findOrFail($id);

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
        'note'       => 'nullable|string',
    ]);

    $transaction->update($request->all());

    return redirect()->route('transactions.index')
                     ->with('success', 'Transaksi berhasil diperbarui!');
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