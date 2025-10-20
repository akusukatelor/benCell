<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\ServiceOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStock = Product::sum('stock'); 
        $productsCount = Product::count();  // Ini sudah benar, akan return 3 jika ada 3 produk
        
        // Query income dan expense yang lebih lengkap (sudah include year untuk akurasi)
        $incomeThisMonth = Transaction::where('type', 'income')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        $incomeThisMonth = Transaction::whereIn('type', ['income', 'income_service'])
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        $expenseThisMonth = Transaction::where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get()
            ->sum('amount');
        $recentService = ServiceOrder::orderByDesc('created_at')->take(5)->get();

        return view('dashboard', compact(
    'productsCount',
    'totalStock',
    'incomeThisMonth',
    'expenseThisMonth',
    'recentService'
));

        // Tambahkan 'productsCount' ke compact() — INI KUNCI PERBAIKANNYA!
        return view('dashboard', compact('totalStock', 'productsCount', 'incomeThisMonth', 'expenseThisMonth', 'recentService'));
    }
}