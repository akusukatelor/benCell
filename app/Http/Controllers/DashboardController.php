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
        $productsCount = Product::count();
        $incomeThisMonth = Transaction::where('type','income')->whereMonth('date', now()->month)->sum('amount');
        $expenseThisMonth = Transaction::where('type','expense')->whereMonth('date', now()->month)->sum('amount');
        $recentService = ServiceOrder::orderByDesc('created_at')->take(5)->get();
// atau sesuai nama field yang benar


        $incomeThisMonth = Transaction::where('type', 'income')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $expenseThisMonth = Transaction::where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $recentService = ServiceOrder::orderByDesc('created_at')->take(5)->get();

        return view('dashboard', compact('totalStock', 'incomeThisMonth', 'expenseThisMonth', 'recentService'));
    }
}