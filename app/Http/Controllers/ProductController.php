<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category'); // Eager load relasi category untuk menghindari N+1 query

        // Jika ada parameter search, filter berdasarkan nama produk secara eksak
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', $request->search); // Exact match: hanya nama persis yang cocok
        }

        // Pagination: ambil data dengan paginasi (misalnya 10 item per halaman)
        $products = $query->paginate(10);

        // Jika ada search, append parameter ke pagination links agar search tetap aktif saat pindah halaman
        if ($request->has('search')) {
            $products->appends(['search' => $request->search]);
        }

        // <-- INI YANG HILANG! Return view ke browser
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Tambah 'string|max:255' untuk validasi lebih baik
            'stock' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();
        $data['sku'] = 'SKU' . time(); // Contoh generate SKU otomatis

        Product::create($data);

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0'
        ]);

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Produk dihapus');
    }
}