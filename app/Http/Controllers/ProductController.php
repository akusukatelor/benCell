<?php
namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


class ProductController extends Controller {
    public function index(){
     $products = Product::with('category')->latest()->get();
    return view('products.index', compact('products'));
}


public function create(){
$categories = Category::all();
return view('products.create', compact('categories'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    Product::create($validated);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
}



public function edit(Product $product){
$categories = Category::all();
return view('products.edit', compact('product','categories'));
}


public function update(Request $request, Product $product){
$data = $request->validate([
'name'=>'required|string',
'category_id'=>'required|exists:categories,id',
'stock'=>'required|integer',
'cost_price'=>'required|numeric',
'sell_price'=>'required|numeric'
]);
$product->update($data);
return redirect()->route('products.index')->with('success','Produk diupdate');
}


public function destroy(Product $product){
$product->delete();
return back()->with('success','Produk dihapus');
}
}