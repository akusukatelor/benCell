<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Ambil input pencarian dari query string
    $search = $request->input('search');

    // Mulai query dengan relasi yang dibutuhkan
    $query = Transaction::with(['product', 'serviceOrder']);

    // Jika user mengetik sesuatu di kolom pencarian
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            // Cari berdasarkan nama produk
            $q->whereHas('product', function ($sub) use ($search) {
                $sub->where('name', 'LIKE', '%' . $search . '%');
            })
            // Atau cari di tipe transaksi
            ->orWhere('type', 'LIKE', '%' . $search . '%')
            // Atau di catatan transaksi
            ->orWhere('note', 'LIKE', '%' . $search . '%');
        });
    }

    // Urutkan dan ambil hasilnya dengan pagination
    $transactions = $query->orderBy('date', 'desc')->paginate(10);

    // Tambahkan parameter search ke pagination links agar tidak hilang
    if ($search) {
        $transactions->appends(['search' => $search]);
    }

    // Kirim data ke view
    return view('transactions.index', compact('transactions'));
}

    

    /**
     * Show the form for creating a new resource.   
     */
    public function create()
    {   
         $products = Product::all();
        $serviceOrders = ServiceOrder::where('status', 'pending')->get();
        return view('transactions.create', compact('products','serviceOrders'));
    }

    /**
     * Store a newly created resource in storage
     */
   public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:income,expense,income_service',
        'product_name' => $request->type !== 'income_service' 
                            ? 'required|string|exists:products,name' 
                            : 'nullable',
        'service_order_id' => $request->type === 'income_service' 
                                ? 'required|exists:service_orders,id' 
                                : 'nullable|exists:service_orders,id',
        'quantity' => $request->type !== 'income_service' ? 'required|integer|min:1' : 'nullable',
        'amount' => $request->type !== 'income_service' ? 'required|numeric|min:0' : 'nullable',
        'date' => 'required|date',
        'note' => 'nullable|string|max:255',
    ]);

    if ($request->type === 'income_service') {
        $serviceOrder = ServiceOrder::findOrFail($request->service_order_id);

        $transaction = Transaction::create([
            'type' => 'income_service',
            'product_id' => null,
            'service_order_id' => $serviceOrder->id,
            'quantity' => 1,
            'amount' => $serviceOrder->estimated_cost,
            'date' => now(),
            'note' => $request->note,
        ]);

        // Update status service order menjadi "selesai"
        $serviceOrder->update(['status' => 'selesai']);

        return redirect()
            ->route('transactions.index')
            ->with('success', "Transaksi servis #{$serviceOrder->id} berhasil ditambahkan.");
    }

    // ===== Hanya untuk tipe income/expense produk =====
    $product = Product::where('name', $request->product_name)->firstOrFail();

    if ($request->type === 'income' && $product->stock < $request->quantity) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors([
                'quantity' => "Stok {$product->name} hanya tersisa {$product->stock} unit.",
            ]);
    }

    if ($request->type === 'income') {
    $totalAmount = $product->sell_price * $request->quantity;
} elseif ($request->type === 'expense') {
    $totalAmount = $product->cost_price * $request->quantity; // ⬅️ hitung total expense
}


    $transaction = Transaction::create([
        'type' => $request->type,
        'product_id' => $product->id,
        'service_order_id' => null,
        'quantity' => $request->quantity,
        'amount' => $totalAmount,
        'date' => now(),
        'note' => $request->note,
    ]);

    // Update stok
    if ($request->type === 'income') {
        $product->decrement('stock', $request->quantity);
    } elseif ($request->type === 'expense') {
        $product->increment('stock', $request->quantity);
    }

    return redirect()
        ->route('transactions.index')
        ->with('success', "Transaksi {$transaction->type} berhasil ditambahkan.");
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