<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
        
        $profitThisMonth = $incomeThisMonth - $expenseThisMonth;
        $recentService = ServiceOrder::orderByDesc('created_at')->take(5)->get();

        // ---------- Data untuk grafik: 6 bulan terakhir ----------
        $months = collect();
        $salesAmount = collect(); // omzet per bulan (income + income_service)
        $profitAmount = collect();  // laba/rugi (income - expense)
        $salesCount = collect();  // jumlah transaksi income per bulan
        $serviceCount = collect(); // jumlah service per bulan

        for ($i = 5; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $label = $dt->format('M Y'); // e.g. Oct 2025
            $months->push($label);

             // Omzet (income + income_service)
            $income = Transaction::whereIn('type', ['income', 'income_service'])
                ->whereMonth('date', $dt->month)
                ->whereYear('date', $dt->year)
                ->sum('amount');

            // Pengeluaran (expense)
            $expense = Transaction::where('type', 'expense')
                ->whereMonth('date', $dt->month)
                ->whereYear('date', $dt->year)
                ->sum('amount');

            $profit = $income - $expense;

            $amount = Transaction::whereIn('type', ['income', 'income_service'])
                ->whereMonth('date', $dt->month)
                ->whereYear('date', $dt->year)
                ->sum('amount');

            $count = Transaction::whereIn('type', ['income', 'income_service'])
                ->whereMonth('date', $dt->month)
                ->whereYear('date', $dt->year)
                ->count();

            $svc = ServiceOrder::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();

            $salesAmount->push((float) $amount);
            $salesCount->push((int) $count);
            $profitAmount->push((float) $profit);
            $serviceCount->push((int) $svc);
        }

        // ---------- Insight: top products & top service types ----------
        // Top sold products by quantity (income transactions, grouped by product)
        $topProducts = Transaction::with('product')
            ->where('type', 'income')
            ->selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get()
            ->map(function($t){
                return [
                    'product_id' => $t->product_id,
                    'name' => $t->product->name ?? 'Unknown',
                    'total_qty' => (int) $t->total_qty
                ];
            });

        // Produk dengan stok minimal 3 atau habis
            // Produk dengan stok minimal 3 atau habis
            $statusProducts = Product::where('stock', '<=', 3)
                ->get()
                ->map(function($p){
                    $color = $p->stock <= 0 ? 'danger' : 'warning';
                    return [
                        'product_id' => $p->id,
                        'name' => $p->name,
                        'stock' => $p->stock,
                        'color' => $color,
                    ];
                });



        // Top service device or common problem (if you have device or problem categorize)
        $topServiceProblems = ServiceOrder::selectRaw('problem, COUNT(*) as cnt')
            ->groupBy('problem')
            ->orderByDesc('cnt')
            ->limit(5)
            ->get();

        // ---------- Simple prediction: average monthly growth -> next month estimate ----------
        // compute average monthly change of salesAmount (simple linear diff)
        $arr = $salesAmount->toArray();
        $deltas = [];
        for ($i = 1; $i < count($arr); $i++) {
            $deltas[] = $arr[$i] - $arr[$i-1];
        }
        $avgDelta = count($deltas) ? (array_sum($deltas) / count($deltas)) : 0;
        $predNextMonth = max(0, end($arr) + $avgDelta); // prevent negative

        // ---------- Prediksi Laba (profit) bulan depan ----------
       $profitArr = $profitAmount->toArray();
$growthRates = [];
for($i=1; $i<count($profitArr); $i++) {
    if($profitArr[$i-1] != 0) {
        $growthRates[] = ($profitArr[$i] - $profitArr[$i-1]) / abs($profitArr[$i-1]);
    }
}
// Rata-rata growth rate
$avgGrowthRate = count($growthRates) ? array_sum($growthRates)/count($growthRates) : 0;

// Prediksi laba bulan depan
$lastProfit = end($profitArr);
$predNextProfit = $lastProfit * (1 + $avgGrowthRate);
$predPercent = $avgGrowthRate * 100; // langsung dalam %



        return view('dashboard', [
    'productsCount' => $productsCount,
    'totalStock' => $totalStock,
    'incomeThisMonth' => $incomeThisMonth,
    'expenseThisMonth' => $expenseThisMonth,
    'profitThisMonth' => $profitThisMonth,
    'predNextMonth' => $predNextMonth,
    'predNextProfit' => $predNextProfit,
    'predPercent' => $predPercent,
    'recentService' => $recentService,

    // ubah semua collection ke array biasa
    'months' => $months->toArray(),
    'salesAmount' => $salesAmount->toArray(),
    'profitAmount' => $profitAmount->toArray(),
    'salesCount' => $salesCount->toArray(),
    'serviceCount' => $serviceCount->toArray(),

    'topProducts' => $topProducts,
    'statusProducts' => $statusProducts,
    'topServiceProblems' => $topServiceProblems,
    'predNextMonth' => $predNextMonth,
]);
    }
}