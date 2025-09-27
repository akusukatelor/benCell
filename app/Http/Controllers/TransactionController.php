<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {   
         $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'date'   => 'required|date',
            'note'   => 'nullable|string',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
{
    // ambil semua produk untuk pilihan dropdown
    $products = Product::all();

    // kirim ke view edit.blade.php
    return view('transactions.edit', compact('transaction', 'products'));
}


    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'type'   => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'date'   => 'required|date',
            'note'   => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $type = $request->type;

        $response = new StreamedResponse(function () use ($from, $to, $type) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'date', 'type', 'product', 'quantity', 'amount', 'note']);

            $query = Transaction::with('product')->orderBy('date', 'desc');
            if ($type) $query->where('type', $type);
            if ($from) $query->whereDate('date', '>=', $from);
            if ($to) $query->whereDate('date', '<=', $to);

            $query->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->date ? $row->date->toDateString() : '',
                        $row->type,
                        $row->product?->name,
                        $row->quantity,
                        $row->amount,
                        $row->note,
                    ]);
                }
            });

            fclose($handle);
        });

        $filename = 'transactions_' . date('YmdHis') . '.csv';
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
